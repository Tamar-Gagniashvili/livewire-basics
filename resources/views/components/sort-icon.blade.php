@if ($sortField !== $field)
    <span></span>
@elseif($sortAsc)
    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
@else 
    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
@endif