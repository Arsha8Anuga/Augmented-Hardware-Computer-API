const { path, csrfToken, apiDashboardUrl } = window.dashboardConfig;

export function apiUrl(extra = "") {
    return `${apiDashboardUrl}${path ? "/" + path : ""}${extra}`;
}

export function request(url, options = {}) {
    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        ...options,
    }).then(async (res) => {
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            alert(err.error || err.message || "error");
            throw new Error(err.error || err.message || "Request failed");
        }

        return res.json().catch(() => ({}));
    });
}

export function getDashboardData() {
    return request(apiUrl());
}

export function createRoot(id) {
    return request(`${apiDashboardUrl}/root`, {
        method: "POST",
        body: JSON.stringify({ id }),
    });
}

export function updateRoot(oldId, id) {
    return request(`${apiDashboardUrl}/root/${encodeURIComponent(oldId)}`, {
        method: "PUT",
        body: JSON.stringify({ id }),
    });
}

export function deleteRoot(id) {
    return request(`${apiDashboardUrl}/root/${encodeURIComponent(id)}`, {
        method: "DELETE",
    });
}

export function createNode(payload) {
    return request(apiUrl(), {
        method: "POST",
        body: JSON.stringify(payload),
    });
}

export function updateNode(key, payload) {
    return request(apiUrl("/" + encodeURIComponent(key)), {
        method: "PUT",
        body: JSON.stringify(payload),
    });
}

export function deleteNode(key) {
    return request(apiUrl("/" + encodeURIComponent(key)), {
        method: "DELETE",
    });
}