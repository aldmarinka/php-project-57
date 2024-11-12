<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        $taskStatus = new TaskStatus();
        $this->saveTaskStatus($taskStatus, $request);
        flash(__('Статус успешно создан'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->saveTaskStatus($taskStatus, $request);
        flash(__('Статус успешно изменён'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        try {
            $taskStatus->delete();
            flash(__('Статус успешно удалён'))->success();
        } catch (\Exception $e) {
            flash(__('Не удалось удалить статус'))->error();
        }
        return redirect()->route('task_statuses.index');
    }

    private function saveTaskStatus(TaskStatus $taskStatus, Request $request)
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
