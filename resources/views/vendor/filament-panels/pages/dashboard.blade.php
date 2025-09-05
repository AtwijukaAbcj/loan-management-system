<x-filament-panels::page class="fi-dashboard-page">
    <h1>Dashboard</h1>
    <x-filament-widgets::widgets :widgets="$this->getVisibleWidgets()" />
</x-filament-panels::page>
