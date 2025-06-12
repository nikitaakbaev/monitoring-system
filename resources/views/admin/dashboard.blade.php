<x-layout>
    <h1>Админ-панель</h1>
    <ul>
        <li><a href="{{ route('admin.users') }}">Пользователи</a></li>
        <li><a href="{{ route('admin.roles') }}">Роли и права</a></li>
        <li><a href="{{ route('admin.schedules') }}">Расписание</a></li>
        <li><a href="{{ route('admin.notifications') }}">Уведомления</a></li>
        <li><a href="{{ route('admin.reports') }}">Отчёты</a></li>
    </ul>
</x-layout>
