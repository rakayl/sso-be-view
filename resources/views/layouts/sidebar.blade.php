<li class="sidebar-toggler-wrapper hide">
	<div class="sidebar-toggler">
		<span></span>
	</div>
</li>

@php
\View::share([
	'menu_active' => $menu_active ?? null,
	'submenu_active' => $submenu_active ?? null,
	'child_active' => $child_active ?? null,
	'level' => session('level'),
]);
@endphp

{!! MyHelper::renderMenu() !!}