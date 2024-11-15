<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     */
    public function index(Request $request): Application|View|Factory
    {
        $tasks = Task::orderBy('id')->paginate();
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Application|View|Factory
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        return view('tasks.create', compact('taskStatuses', 'users'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->getValidatedData($request);
        $validatedData['created_by_id'] = auth()->id();

        Task::create($validatedData);

        flash(__('Задача успешно создана'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * @param Task $task
     *
     * @return Factory|View|Application
     */
    public function edit(Task $task): Application|View|Factory
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users'));
    }

    /**
     * @param Request $request
     * @param Task    $task
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validatedData = $this->getValidatedData($request);

        $task->update($validatedData);

        flash(__('Задача успешно изменена'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * @param Task $task
     *
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        flash(__('Задача успешно удалена'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * @param string $id
     *
     * @return Factory|View|Application
     */
    public function show(string $id): Application|View|Factory
    {
        $task = Task::findOrFail((int)$id);
        return view('tasks.show', compact('task'));
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getValidatedData(Request $request): array
    {
        return $request->validate([
                                                'name' => 'required|string|max:255',
                                                'description' => 'nullable|string|max:1000',
                                                'status_id' => 'required|exists:task_statuses,id',
                                                'assigned_to_id' => 'nullable|exists:users,id',
                                                'labels' => 'array',
                                                'labels.*' => 'exists:labels,id',
                                            ], [
                                                'name.required' => 'Это обязательное поле',
                                                'name.max' => 'Имя задачи не должно превышать 255 символов.',
                                                'description.max' => 'Описание не должно превышать 1000 символов.',
                                            ]);
    }
}
