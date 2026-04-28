<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-slate-800">
        <flux:header container class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Início') }}
                </flux:navbar.item>
                <flux:navbar.item icon="trophy" :href="route('groups.index')" :current="request()->routeIs('groups.*')" wire:navigate>
                    {{ __('Meus Bolões') }}
                </flux:navbar.item>
                @if (auth()->user()->is_admin)
                    <flux:navbar.item icon="shield-check" :href="route('admin.groups.index')" :current="request()->routeIs('admin.*')" wire:navigate>
                        {{ __('Admin') }}
                    </flux:navbar.item>
                @endif
            </flux:navbar>

            <flux:spacer />

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Bolão da Copa')">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Início') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="trophy" :href="route('groups.index')" :current="request()->routeIs('groups.*')" wire:navigate>
                        {{ __('Meus Bolões') }}
                    </flux:sidebar.item>
                    @if (auth()->user()->is_admin)
                        <flux:sidebar.item icon="shield-check" :href="route('admin.groups.index')" :current="request()->routeIs('admin.*')" wire:navigate>
                            {{ __('Admin') }}
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
