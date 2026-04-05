let modalMode = null;
let modalTargetKey = null;
let modalTargetRoot = null;

export function getModalState() {
    return {
        modalMode,
        modalTargetKey,
        modalTargetRoot,
    };
}

export function setModalState(state) {
    modalMode = state.modalMode ?? modalMode;
    modalTargetKey = state.modalTargetKey ?? null;
    modalTargetRoot = state.modalTargetRoot ?? null;
}

export function bindModalBaseEvents(onSubmit) {
    document.getElementById("crudForm")?.addEventListener("submit", onSubmit);
    document.getElementById("fieldType")?.addEventListener("change", handleTypeChange);
    document.getElementById("closeModalBtn")?.addEventListener("click", closeModal);
    document.getElementById("cancelModalBtn")?.addEventListener("click", closeModal);
    document.getElementById("modalBackdrop")?.addEventListener("click", closeModal);
}

export function openModal({
    title = "Form",
    key = "",
    type = "",
    value = "",
    hideKey = false,
    hideType = false,
    hideValue = false,
    warning = false,
}) {
    document.getElementById("modalTitle").innerText = title;
    document.getElementById("fieldKey").value = key;
    document.getElementById("fieldType").value = type;
    document.getElementById("fieldValue").value = value ?? "";

    document.getElementById("fieldKeyWrapper").classList.toggle("hidden", hideKey);
    document.getElementById("fieldTypeWrapper").classList.toggle("hidden", hideType);
    document.getElementById("fieldValueWrapper").classList.toggle("hidden", hideValue);
    document.getElementById("objectWarning").classList.toggle("hidden", !warning);

    handleTypeChange();
    document.getElementById("crudModal").classList.remove("hidden");
}

export function closeModal() {
    document.getElementById("crudModal").classList.add("hidden");
    modalMode = null;
    modalTargetKey = null;
    modalTargetRoot = null;
}

export function handleTypeChange() {
    const type = document.getElementById("fieldType").value;
    const valueWrapper = document.getElementById("fieldValueWrapper");

    if (modalMode === "add-root" || modalMode === "edit-root") return;

    valueWrapper.classList.toggle("hidden", type === "object");
}

export function openRootCreateModal() {
    modalMode = "add-root";

    openModal({
        title: "Add Root",
        hideType: true,
        hideValue: true,
    });
}

export function openRootEditModal(id) {
    modalMode = "edit-root";
    modalTargetRoot = id;

    openModal({
        title: "Rename Root",
        key: id,
        hideType: true,
        hideValue: true,
    });
}

export function openNodeCreateModal() {
    modalMode = "add-node";

    openModal({
        title: "Add Node",
        key: "",
        type: "",
        value: "",
    });
}

export function openNodeEditModal(key, type, value) {
    modalMode = "edit-node";
    modalTargetKey = key;

    openModal({
        title: `Edit Node: ${key}`,
        key,
        type,
        value: type === "object" ? "" : value,
        hideKey: true,
        warning: type === "object",
    });
}