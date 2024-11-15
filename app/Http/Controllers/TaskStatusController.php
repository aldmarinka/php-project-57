<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Application|View|Factory
    {
        $taskStatuses = TaskStatus::orderBy('id')->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Application|View|Factory
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $taskStatus = new TaskStatus();
        $this->saveTaskStatus($taskStatus, $request);
        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно создан');
    }

    /**
     * @param TaskStatus $taskStatus
     *
     * @return Factory|View|Application
     */
    public function edit(TaskStatus $taskStatus): Application|View|Factory
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * @param Request    $request
     * @param TaskStatus $taskStatus
     *
     * @return RedirectResponse
     */
    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
        $this->saveTaskStatus($taskStatus, $request);
        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно изменён');
    }

    /**
     * @param TaskStatus $taskStatus
     *
     * @return RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        try {
            if ($taskStatus->tasks()->count() > 0) {
                return redirect()->route('task_statuses.index')
                                 ->with('error', 'Невозможно удалить статус, связанный с задачей');
            }

            $taskStatus->delete();
        } catch (\Exception $e) {
            return redirect()->route('task_statuses.index')
                             ->with('error', 'Не удалось удалить статус');
        }
        return redirect()->route('task_statuses.index')->with('success', 'Статус успешно удалён');
    }

    /**
     * @param TaskStatus $taskStatus
     * @param Request    $request
     *
     * @return void
     */
    private function saveTaskStatus(TaskStatus $taskStatus, Request $request): void
    {
        $validated = $request->validate([
                                            'name' => 'required|min:1|max:255|unique:task_statuses',
                                        ], [
                                            'name.required' => 'Это обязательное поле',
                                            'name.min' => 'Имя статуса должно содержать хотя бы один символ.',
                                            'name.max' => 'Имя статуса не должно превышать 255 символов.',
                                            'name.unique' => 'Статус с таким именем уже существует.',
                                        ]);
        $taskStatus->fill($validated);
        $taskStatus->save();
    }
}
