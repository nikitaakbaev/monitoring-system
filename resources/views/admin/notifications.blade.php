<x-layout>
    <h1>Настройка уведомлений</h1>
    <form method="POST" action="{{ route('admin.notifications.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Порог успеваемости</label>
            <input type="text" name="settings[grade_threshold]" class="form-control" value="{{ $settings->firstWhere('setting_key','grade_threshold')->setting_value ?? '' }}">
        </div>
        <button class="btn btn-primary">Сохранить</button>
    </form>
</x-layout>
