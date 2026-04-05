<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateRootRequest;
use App\Http\Requests\Dashboard\StoreNodeRequest;
use App\Http\Requests\Dashboard\UpdateNodeRequest;
use App\Http\Requests\Dashboard\UpdateRootRequest;
use App\Models\Node;
use App\Services\DashboardTreeService;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    public function __construct(
        protected DashboardTreeService $tree
    ) {}

    public function get(?string $path = null): JsonResponse
    {
        if (!$path) {
            return response()->json(Node::select('root_id')->get());
        }

        return response()->json($this->tree->get($path));
    }

    public function createRoot(CreateRootRequest $request): JsonResponse
    {
        $this->tree->createRoot($request->validated('id'));

        return response()->json(['ok' => true]);
    }

    public function deleteRoot(string $id): JsonResponse
    {
        $this->tree->deleteRoot($id);

        return response()->json(['ok' => true]);
    }

    public function updateRoot(UpdateRootRequest $request, string $id): JsonResponse
    {
        $this->tree->renameRoot($id, $request->validated('id'));

        return response()->json(['ok' => true]);
    }

    public function store(StoreNodeRequest $request, ?string $path = null): JsonResponse
    {
        $this->tree->store($path, $request->validated());

        return response()->json(['ok' => true]);
    }

    public function update(UpdateNodeRequest $request, string $path): JsonResponse
    {
        $this->tree->update($path, $request->validated());

        return response()->json(['ok' => true]);
    }

    public function destroy(string $path): JsonResponse
    {
        $this->tree->destroy($path);

        return response()->json(['ok' => true]);
    }
}