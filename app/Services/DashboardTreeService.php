<?php

namespace App\Services;

use App\Models\Node;
use Illuminate\Http\Exceptions\HttpResponseException;

class DashboardTreeService
{
    public function get(string $path): array
    {
        $segments = $this->normalizePath($path);

        if (empty($segments)) {
            $this->abortJson('invalid path', 400);
        }

        $rootId = $segments[0];
        $node = Node::where('root_id', $rootId)->first();

        if (!$node) {
            $this->abortJson('not found', 404);
        }

        $current = $node->data ?? [];

        for ($i = 1; $i < count($segments); $i++) {
            if (!is_array($current) || !array_key_exists($segments[$i], $current)) {
                $this->abortJson('not found', 404);
            }

            $current = $current[$segments[$i]];
        }

        return [
            'type' => $this->detectType($current),
            'data' => $current,
        ];
    }

    public function createRoot(string $id): void
    {
        $id = $this->normalizeKey($id);

        if (!$id || $id === 'root') {
            $this->abortJson('invalid id', 400);
        }

        if (Node::where('root_id', $id)->exists()) {
            $this->abortJson('id exists', 400);
        }

        Node::create([
            'root_id' => $id,
            'data' => [],
        ]);
    }

    public function deleteRoot(string $id): void
    {
        $id = $this->normalizeKey($id);

        $node = Node::where('root_id', $id)->first();

        if (!$node) {
            $this->abortJson('not found', 404);
        }

        $node->delete();
    }

    public function renameRoot(string $oldId, string $newId): void
    {
        $oldId = $this->normalizeKey($oldId);
        $newId = $this->normalizeKey($newId);

        if (!$newId || $newId === 'root') {
            $this->abortJson('invalid id', 400);
        }

        if ($oldId !== $newId && Node::where('root_id', $newId)->exists()) {
            $this->abortJson('id exists', 400);
        }

        $node = Node::where('root_id', $oldId)->first();

        if (!$node) {
            $this->abortJson('not found', 404);
        }

        $node->update([
            'root_id' => $newId,
        ]);
    }

    public function store(?string $path, array $payload): void
    {
        if (!$path) {
            $this->abortJson('path required', 400);
        }

        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) $this->abortJson('root not found', 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if (!isset($ref[$seg])) {
                $ref[$seg] = [];
            }

            if (!is_array($ref[$seg])) {
                $this->abortJson('cannot add child to non-object', 400);
            }

            $ref = &$ref[$seg];
        }

        $key = $this->normalizeKey($payload['key']);

        if (!$key) {
            $this->abortJson('invalid key', 400);
        }

        if (isset($ref[$key])) {
            $this->abortJson('duplicate key', 400);
        }

        $ref[$key] = $this->castValue($payload);

        $node->data = $data;
        $node->save();
    }

    public function update(string $path, array $payload): void
    {
        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) $this->abortJson('root not found', 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if ($i === count($segments) - 1) {
                $ref[$seg] = $this->castValue($payload);
            } else {
                if (!isset($ref[$seg]) || !is_array($ref[$seg])) {
                    $this->abortJson('invalid path', 400);
                }

                $ref = &$ref[$seg];
            }
        }

        $node->data = $data;
        $node->save();
    }

    public function destroy(string $path): void
    {
        $segments = $this->normalizePath($path);
        $rootId = $segments[0];

        $node = Node::where('root_id', $rootId)->first();
        if (!$node) $this->abortJson('root not found', 404);

        $data = $node->data ?? [];
        $ref = &$data;

        for ($i = 1; $i < count($segments); $i++) {
            $seg = $segments[$i];

            if ($i === count($segments) - 1) {
                unset($ref[$seg]);
            } else {
                if (!isset($ref[$seg]) || !is_array($ref[$seg])) {
                    $this->abortJson('invalid path', 400);
                }

                $ref = &$ref[$seg];
            }
        }

        $node->data = $data;
        $node->save();
    }

    private function normalizeKey($key): string
    {
        return strtolower(trim((string) $key));
    }

    private function normalizePath(string $path): array
    {
        return array_values(array_filter(array_map(
            fn ($p) => strtolower(trim($p)),
            explode('/', $path)
        )));
    }

    private function castValue(array $payload): mixed
    {
        return match ($payload['type']) {
            'object' => [],
            'number' => (int) $payload['value'],
            default => (string) $payload['value'],
        };
    }

    private function detectType(mixed $value): string
    {
        if (is_array($value)) return 'object';
        if (is_int($value) || is_float($value)) return 'number';
        return 'string';
    }

    private function abortJson(string $message, int $status): never
    {
        throw new HttpResponseException(
            response()->json(['error' => $message], $status)
        );
    }
}