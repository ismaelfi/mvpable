@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white rounded-md border border-gray-300 cursor-default dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-blue-300 transition duration-150 ease-in-out dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600 hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                {!! __('pagination.previous') !!}
                        </button>
                    @else
                        <button
                            type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-blue-300 transition duration-150 ease-in-out dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600 hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                {!! __('pagination.previous') !!}
                        </button>
                    @endif
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-blue-300 transition duration-150 ease-in-out dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600 hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                {!! __('pagination.next') !!}
                        </button>
                    @else
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-blue-300 transition duration-150 ease-in-out dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600 hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                {!! __('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white rounded-md border border-gray-300 cursor-default">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
