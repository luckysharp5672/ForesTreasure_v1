@php
    $userType = auth()->user()->user_type;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <!-- 森林登録 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(in_array(auth()->user()->userType->type_name, ['森林所有者', '管理者']))
                        <a class="text-blue-500 hover:text-blue-700" href="{{ route('forest.index') }}">{{ __('森林登録') }}</a>
                    @else
                        <span style="color: grey;">森林登録</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- 立木検索 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(in_array(auth()->user()->userType->type_name, ['森林所有者', '木材探求者', '管理者']))
                        <a class="text-blue-500 hover:text-blue-700" href="{{ route('timber_search') }}">{{ __('立木検索') }}</a>
                    @else
                        <span style="color: grey;">立木検索</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- 作業一覧 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(in_array(auth()->user()->userType->type_name, ['森林所有者', '木材探求者', '林業家', '管理者']))
                        <a class="text-blue-500 hover:text-blue-700" href="{{ route('work_requests') }}">{{ __('作業一覧') }}</a>
                    @else
                        <span style="color: grey;">作業一覧</span>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
