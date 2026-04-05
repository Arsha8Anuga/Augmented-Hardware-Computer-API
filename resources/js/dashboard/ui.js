const { path, dashboardUrl } = window.dashboardConfig;

export function renderBreadcrumb() {
    const el = document.getElementById("breadcrumb");

    if (!path) {
        el.innerHTML = `
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-cyan-400/15 bg-cyan-400/5 text-cyan-300 text-sm">
                <span>root</span>
            </span>
        `;
        return;
    }

    const segments = path.split("/");
    let currentPath = "";

    let html = `
        <a
            href="${dashboardUrl}"
            class="inline-flex items-center px-3 py-1.5 rounded-full border border-cyan-400/15 bg-cyan-400/5 text-cyan-300 no-underline transition hover:bg-cyan-400/10 hover:border-cyan-400/35"
        >
            root
        </a>
    `;

    segments.forEach((seg) => {
        currentPath += (currentPath ? "/" : "") + seg;

        html += `
            <span class="text-slate-500">/</span>
            <a
                href="${dashboardUrl}/${currentPath}"
                class="inline-flex items-center px-3 py-1.5 rounded-full border border-white/10 bg-white/5 text-slate-200 no-underline transition hover:bg-cyan-400/10 hover:text-cyan-300 hover:border-cyan-400/25"
            >
                ${seg}
            </a>
        `;
    });

    el.innerHTML = html;
}

export function goBack() {
    if (!path) return;

    const segments = path.split("/");
    segments.pop();

    const newPath = segments.join("/");
    window.location.href = `${dashboardUrl}${newPath ? "/" + newPath : ""}`;
}