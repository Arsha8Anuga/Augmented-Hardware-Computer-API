import { getDashboardData, createRoot, updateRoot, deleteRoot, createNode, updateNode, deleteNode } from "./api";
import { bindModalBaseEvents, getModalState, closeModal, openRootCreateModal, openRootEditModal, openNodeCreateModal, openNodeEditModal } from "./modal";
import { renderBreadcrumb, goBack } from "./ui";
import { renderRoot, renderObject } from "./render";

const { path, dashboardUrl } = window.dashboardConfig;

document.addEventListener("DOMContentLoaded", init);

function init() {
    document.getElementById("addBtn")?.addEventListener("click", handleAdd);
    bindModalBaseEvents(submitModalForm);
    loadData();
}

function loadData() {
    getDashboardData().then(render);
}

function render(res) {
    const app = document.getElementById("app");
    const back = document.getElementById("backs");

    app.innerHTML = "";
    back.innerHTML = "";
    renderBreadcrumb();

    if (!path) {
        renderRoot(res, app);
        bindRootActions();
        return;
    }

    if (res.type === "object") {
        back.innerHTML = `
            <button
                id="backBtn"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-cyan-400/25 bg-white/5 text-slate-200 transition-all duration-300 hover:bg-cyan-400/10 hover:border-cyan-400/50 hover:text-cyan-300"
            >
                <span>←</span>
                <span>Back</span>
            </button>
        `;

        document.getElementById("backBtn")?.addEventListener("click", goBack);
        renderObject(res.data, app);
        bindNodeActions();
    } else {
        app.innerHTML = `
            <div class="col-span-full">
                <div class="rounded-[22px] border border-cyan-400/20 bg-white/5 backdrop-blur-md p-7 shadow-[0_10px_30px_rgba(0,0,0,0.25)]">
                    <p class="text-xs tracking-[2px] uppercase text-cyan-400/80 mb-3">Value</p>
                    <h3 class="text-3xl font-bold text-white break-words">${res.data}</h3>
                </div>
            </div>
        `;
    }
}

function bindRootActions() {
    document.querySelectorAll(".rename-root-btn").forEach((btn) => {
        btn.addEventListener("click", () => openRootEditModal(btn.dataset.id));
    });

    document.querySelectorAll(".delete-root-btn").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("hapus root?")) return;
            await deleteRoot(btn.dataset.id);
            loadData();
        });
    });
}

function bindNodeActions() {
    document.querySelectorAll(".edit-node-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            openNodeEditModal(btn.dataset.key, btn.dataset.type, btn.dataset.value);
        });
    });

    document.querySelectorAll(".delete-node-btn").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("hapus?")) return;
            await deleteNode(btn.dataset.key);
            loadData();
        });
    });
}

function handleAdd() {
    if (!path) {
        openRootCreateModal();
    } else {
        openNodeCreateModal();
    }
}

async function submitModalForm(e) {
    e.preventDefault();

    const { modalMode, modalTargetKey, modalTargetRoot } = getModalState();

    const key = document.getElementById("fieldKey").value.trim();
    const type = document.getElementById("fieldType").value;
    let value = document.getElementById("fieldValue").value;

    if (modalMode === "add-root") {
        if (!key) return alert("root id wajib diisi");
        await createRoot(key);
        closeModal();
        loadData();
        return;
    }

    if (modalMode === "edit-root") {
        if (!key) return alert("new id wajib diisi");
        await updateRoot(modalTargetRoot, key);
        closeModal();
        window.location.href = `${dashboardUrl}/${encodeURIComponent(key)}`;
        return;
    }

    if (!type) return alert("type wajib diisi");

    if (type === "number") {
        value = Number(value);
        if (Number.isNaN(value)) return alert("value harus angka");
    }

    if (type === "object") {
        value = {};
    }

    if (modalMode === "add-node") {
        if (!key) return alert("key wajib diisi");
        await createNode({ key, type, value });
        closeModal();
        loadData();
        return;
    }

    if (modalMode === "edit-node") {
        await updateNode(modalTargetKey, { type, value });
        closeModal();
        loadData();
    }
}