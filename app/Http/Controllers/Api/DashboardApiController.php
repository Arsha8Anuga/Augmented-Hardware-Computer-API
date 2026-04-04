<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Node;

class DashboardApiController extends Controller
{
    /* ================= GET ================= */
    public function get($path = null)
    {
        if (!$path) {
            return response()->json(Node::all());
        }

        $segments = $this->normalizePath($path);
        if (empty($segments)) {
            return response()->json(['error' => 'invalid path'], 400);
        }

        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) return response()->json(['error' => 'not found'], 404);

        $current = $node->data ?? [];

        for ($i = 1; $i < count($segments); $i++) {
            if (!is_array($current) || !isset($current[$segments[$i]])) {
                return response()->json(['error' => 'not found'], 404);
            }
            $current = $current[$segments[$i]];
        }

        return response()->json([
            'type' => $this->detectType($current),
            'data' => $current
        ]);
    }

    /* ================= CREATE ROOT ================= */
    public function createRoot(Request $req)
    {
        $id = $this->normalizeKey($req->id);


        if (!$id || $id == "root") {
            return response()->json(['error' => 'invalid id'], 400);
        }

        if (Node::where('root_id', $id)->exists()) {
            return response()->json(['error' => 'id exists'], 400);
        }

        Node::create([
            'root_id' => $id,
            'data' => []
        ]);

        return response()->json(['ok' => true]);
    }

    public function deleteRoot($id)
    {
        $id = $this->normalizeKey($id);

        $node = Node::where('root_id', $id)->first();
        if (!$node) return response()->json(['error' => 'not found'], 404);

        $node->delete();

        return response()->json(['ok' => true]);
    }

    public function updateRoot(Request $req, $id)
    {
        $id = $this->normalizeKey($id);
        $newId = $this->normalizeKey($req->id);

        if (!$newId) {
            return response()->json(['error' => 'invalid id'], 400);
        }

        if (Node::where('root_id', $newId)->exists()) {
            return response()->json(['error' => 'id exists'], 400);
        }

        $node = Node::where('root_id', $id)->first();
        if (!$node) return response()->json(['error' => 'not found'], 404);

        $node->root_id = $newId;
        $node->save();

        return response()->json(['ok' => true]);
    }

    /* ================= ADD ================= */
    public function store(Request $req, $path = null)
    {
        if (!$path) {
            return response()->json(['error' => 'path required'], 400);
        }

        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) return response()->json(['error' => 'root not found'], 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if (!isset($ref[$seg])) {
                $ref[$seg] = [];
            }

            if (!is_array($ref[$seg])) {
                return response()->json(['error' => 'cannot add child to non-object'], 400);
            }

            $ref = &$ref[$seg];
        }

        $key = $this->normalizeKey($req->key);

        if (!$key) {
            return response()->json(['error' => 'invalid key'], 400);
        }

        if (isset($ref[$key])) {
            return response()->json(['error' => 'duplicate key'], 400);
        }

        $ref[$key] = $this->castValue($req);

        $node->data = $data;
        $node->save();

        return response()->json(['ok' => true]);
    }

    /* ================= UPDATE ================= */
    public function update(Request $req, $path)
    {
        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) return response()->json(['error' => 'root not found'], 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if ($i === count($segments) - 1) {
                // overwrite
                $ref[$seg] = $this->castValue($req);
            } else {
                if (!isset($ref[$seg]) || !is_array($ref[$seg])) {
                    return response()->json(['error' => 'invalid path'], 400);
                }
                $ref = &$ref[$seg];
            }
        }

        $node->data = $data;
        $node->save();

        return response()->json(['ok' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($path)
    {
        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) return response()->json(['error' => 'root not found'], 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if ($i === count($segments) - 1) {
                unset($ref[$seg]);
            } else {
                if (!isset($ref[$seg]) || !is_array($ref[$seg])) {
                    return response()->json(['error' => 'invalid path'], 400);
                }
                $ref = &$ref[$seg];
            }
        }

        $node->data = $data;
        $node->save();

        return response()->json(['ok' => true]);
    }

    /* ================= HELPERS ================= */

    private function normalizeKey($key)
    {
        return strtolower(trim((string)$key));
    }

    private function normalizePath($path)
    {
        return array_values(array_filter(array_map(
            fn($p) => strtolower(trim($p)),
            explode('/', $path)
        )));
    }

    private function castValue($req)
    {
        if (!in_array($req->type, ['string', 'number', 'object'])) {
            abort(400, 'invalid type');
        }

        if ($req->type === 'object') return [];
        if ($req->type === 'number') return (int)$req->value;

        return (string)$req->value;
    }

    private function detectType($value)
    {
        if (is_array($value)) return 'object';
        if (is_int($value) || is_float($value)) return 'number';
        return 'string';
    }
}