import { escapeHtml, escapeHtmlAttr } from "./utils";
const { path, dashboardUrl } = window.dashboardConfig;

export function renderRoot(nodes, app) {
    nodes.forEach((node) => {
        const div = document.createElement("div");

        div.className = `
            group relative overflow-hidden
            bg-white/5 border border-cyan-400/10 border-l-4 border-l-cyan-400
            rounded-2xl px-6 py-5 flex flex-col justify-between gap-5
            transition-all duration-300
            hover:bg-cyan-400/10 hover:border-cyan-400/35 hover:-translate-y-1
            hover:shadow-[0_10px_25px_rgba(0,0,0,0.35)]
        `;

        div.innerHTML = `
            <div class="absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-cyan-400/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>

            <div class="space-y-1">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-xl font-semibold text-white break-words">${escapeHtml(node.root_id)}</h3>
                        <p class="text-sm text-slate-400 mt-1">Root Node</p>
                    </div>

                    <div class="shrink-0 px-2.5 py-1 rounded-full border border-cyan-400/15 bg-cyan-400/5 text-[11px] uppercase tracking-[1.5px] text-cyan-300">
                        Root
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 pt-1">
                <a
                    href="${window.dashboardConfig.dashboardUrl}/${encodeURIComponent(node.root_id)}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-cyan-400/10 border border-cyan-400/20 text-cyan-300 no-underline transition-all duration-300 hover:bg-cyan-400/20 hover:border-cyan-400/45 hover:text-cyan-200"
                >
                    <span>Open</span>
                    <span>→</span>
                </a>

                <button
                    data-id="${escapeHtmlAttr(node.root_id)}"
                    class="rename-root-btn px-4 py-2.5 rounded-xl border border-amber-400/20 bg-transparent text-amber-300 transition-all duration-300 hover:bg-amber-500 hover:text-white hover:shadow-[0_0_15px_rgba(245,158,11,0.35)] hover:border-amber-500"
                >
                    Rename
                </button>

                <button
                    data-id="${escapeHtmlAttr(node.root_id)}"
                    class="delete-root-btn px-4 py-2.5 rounded-xl border border-red-400/20 bg-transparent text-red-400 transition-all duration-300 hover:bg-red-500 hover:text-white hover:shadow-[0_0_15px_rgba(255,77,77,0.45)] hover:border-red-500"
                    title="Delete"
                >
                    Delete
                </button>
            </div>
        `;

        app.appendChild(div);
    });
}

export function renderObject(data, app) {
    for (const key in data) {
        const value = data[key];
        const isObject = value !== null && typeof value === "object";
        const type = isObject ? "object" : (typeof value === "number" ? "number" : "string");

        const div = document.createElement("div");

        div.className = `
            group relative overflow-hidden
            bg-white/5 border border-cyan-400/10 border-l-4 border-l-cyan-400
            rounded-2xl px-6 py-5 flex flex-col justify-between gap-5
            transition-all duration-300
            hover:bg-cyan-400/10 hover:border-cyan-400/35 hover:-translate-y-1
            hover:shadow-[0_10px_25px_rgba(0,0,0,0.35)]
        `;

        div.innerHTML = `
            <div class="absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-cyan-400/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>

            <div class="space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-lg font-semibold text-white break-words">${escapeHtml(key)}</h3>
                        <p class="text-sm text-cyan-400/75 uppercase tracking-[1.2px] mt-1">${type}</p>
                    </div>

                    <div class="shrink-0 px-2.5 py-1 rounded-full border border-cyan-400/15 bg-cyan-400/5 text-[11px] uppercase tracking-[1.5px] text-cyan-300">
                        ${type}
                    </div>
                </div>

                <div class="text-slate-200 break-words min-h-[52px] flex items-start">
                    ${
                        isObject
                            ? `
                                <a
                                    href="${window.dashboardConfig.dashboardUrl}/${window.dashboardConfig.path}/${encodeURIComponent(key)}"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-cyan-400/10 border border-cyan-400/20 text-cyan-300 no-underline transition-all duration-300 hover:bg-cyan-400/20 hover:border-cyan-400/45 hover:text-cyan-200"
                                >
                                    <span>Open</span>
                                    <span>→</span>
                                </a>
                            `
                            : `
                                <div class="w-full rounded-xl border border-white/5 bg-black/10 px-4 py-3 text-slate-100 leading-relaxed">
                                    ${escapeHtml(String(value))}
                                </div>
                            `
                    }
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 pt-1">
                <button
                    data-key="${escapeHtmlAttr(key)}"
                    data-type="${escapeHtmlAttr(type)}"
                    data-value='${isObject ? "" : escapeHtmlAttr(String(value))}'
                    class="edit-node-btn px-4 py-2.5 rounded-xl border border-amber-400/20 bg-transparent text-amber-300 transition-all duration-300 hover:bg-amber-500 hover:text-white hover:shadow-[0_0_15px_rgba(245,158,11,0.35)] hover:border-amber-500"
                >
                    Edit
                </button>

                <button
                    data-key="${escapeHtmlAttr(key)}"
                    class="delete-node-btn px-4 py-2.5 rounded-xl border border-red-400/20 bg-transparent text-red-400 transition-all duration-300 hover:bg-red-500 hover:text-white hover:shadow-[0_0_15px_rgba(255,77,77,0.45)] hover:border-red-500"
                    title="Delete"
                >
                    Delete
                </button>
            </div>
        `;

        app.appendChild(div);
    }
}