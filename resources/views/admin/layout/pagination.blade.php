<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
    <ul class="pagination">
        <li class="paginate_button page-item previous" id="example2_previous">
            <a href="{{ $pagination->previousPageUrl() }}" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Anterior</a>
        </li>

        @for($i = 1; $i <= $pagination->lastPage(); $i++)
            @if($pagination->currentPage() == $i)
                <li class="paginate_button page-item active">
            @else 
                <li class="paginate_button page-item">
            @endif    
                <a href="{{ $pagination->url($i) }}" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">{{ $i }}</a>
                </li>
        @endfor
    
        <li class="paginate_button page-item next" id="example2_next">
            <a href="{{ $pagination->nextPageUrl() }}" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Próxima</a>
        </li>
    </ul>
</div>