<h2>DASHBOARD</h2>
<div id="breadcrumb"></div>
<div id="backs"></div>
<div id="app"></div>
<button onclick="handleAdd()">Add</button>

<script>
const path = "{{ $path ?? '' }}";

init();

function init() {
    loadData();
}

/* ================= FETCH ================= */

function apiUrl(extra = '') {
    return `/api/dashboard${path ? '/' + path : ''}${extra}`;
}

function request(url, options = {}) {
    return fetch(url, {
        headers: { "Content-Type": "application/json" },
        ...options
    }).then(async res => {
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            alert(err.error || "error");
            throw new Error(err.error);
        }
        return res.json().catch(() => ({}));
    });
}

/* ================= LOAD ================= */

function loadData() {
    request(apiUrl())
        .then(render);
}

/* ================= RENDER ================= */

function render(res) {
    const app = document.getElementById('app');
    const back = document.getElementById('backs');
    app.innerHTML = '';
    renderBreadcrumb();
    if (!path) {
        renderRoot(res, app);
        return;
    }    

    if (res.type === 'object') {

        back.innerHTML = '<button onclick="goBack()">Back</button>';
        renderObject(res.data, app);
        
    } else {
        app.innerHTML = `<h3>VALUE: ${res.data}</h3>`;
    }

    
}

function renderRoot(nodes, app) {
    nodes.forEach(node => {
        const div = document.createElement('div');

        div.style.border = "1px solid #aaa";
        div.style.margin = "5px";
        div.style.padding = "10px";

        div.innerHTML = `
            <b>${node.root_id}</b><br>
            <a href="/dashboard/${node.root_id}">OPEN</a><br><br>

            <button onclick="editRoot('${node.root_id}')">Rename</button>
            <button onclick="deleteRoot('${node.root_id}')">Delete</button>
        `;

        app.appendChild(div);
    });
}

function renderObject(data, app) {
    for (const key in data) {
        const value = data[key];
        const isObject = value !== null && typeof value === 'object';
        const isNumber = value !== null && typeof value === 'number';
        
        const div = document.createElement('div');
        div.style.border = "1px solid #aaa";
        div.style.margin = "5px";
        div.style.padding = "10px";

        div.innerHTML = `
            <b>${key}</b><br>
            ${isObject ? 'OBJECT' : (isNumber ? "NUMBER" : "STRING")}<br>

            ${isObject ? `<a href="/dashboard/${path}/${key}">OPEN</a><br>` : value}

            <br>
            <button onclick="handleEdit('${key}')">Edit</button>
            <button onclick="handleDelete('${key}')">Delete</button>
        `;

        app.appendChild(div);
    }
}

/* ================= CRUD ================= */

function handleAdd() {
    if (!path) {
        createRoot();
    } else {
        createNode();
    }
}

function createRoot() {
    const id = prompt("root id:");
    if (!id) return;

    request('/api/dashboard/root', {
        method: "POST",
        body: JSON.stringify({ id })
    }).then(loadData);
}

function deleteRoot(id) {
    if (!confirm("hapus root?")) return;

    request(`/api/dashboard/root/${id}`, {
        method: "DELETE"
    }).then(loadData);
}

function editRoot(id) {
    const newId = prompt("new id:");
    if (!newId) return;

    request(`/api/dashboard/root/${id}`, {
        method: "PUT",
        body: JSON.stringify({ id: newId })
    }).then(() => {
        window.location.href = `/dashboard/${newId}`;
    });;
}

function createNode() {
    const key = prompt("key:");
    if (!key) return;

    const { type, value } = askValue();
    if (!type) return;

    request(apiUrl(), {
        method: "POST",
        body: JSON.stringify({ key, type, value })
    }).then(loadData);
}

function handleEdit(key) {
    const { type, value } = askValue(true);
    if (!type) return;

    request(apiUrl('/' + key), {
        method: "PUT",
        body: JSON.stringify({ type, value })
    }).then(loadData);
}

function handleDelete(key) {
    if (!confirm("hapus?")) return;

    request(apiUrl('/' + key), {
        method: "DELETE"
    }).then(loadData);
}

/* ================= INPUT HELPER ================= */

function askValue(isEdit = false) {
    const type = prompt("type (string/number/object):");
    if (!type) return {};

    let value = "";

    if (type === "string") {
        value = prompt("value:");
        if (value === null) return {};
    }

    if (type === "number") {
        const val = prompt("value:");
        if (val === null) return {};
        value = parseInt(val);
    }

    if (type === "object") {
        if (isEdit) alert("child akan hilang");
        value = {};
    }

    return { type, value };
}

function renderBreadcrumb() {
    const el = document.getElementById('breadcrumb');

    if (!path) {
        el.innerHTML = `<b>root</b>`;
        return;
    }

    const segments = path.split('/');
    let currentPath = '';

    let html = `<a href="/dashboard">root</a>`;

    segments.forEach(seg => {
        currentPath += (currentPath ? '/' : '') + seg;

        html += ` / <a href="/dashboard/${currentPath}">${seg}</a>`;
    });

    el.innerHTML = html;
}

function goBack() {
    if (!path) return;

    const segments = path.split('/');
    segments.pop();

    const newPath = segments.join('/');

    window.location.href = `/dashboard${newPath ? '/' + newPath : ''}`;
}
</script>