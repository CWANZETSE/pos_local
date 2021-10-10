@if ($paginator->hasPages())


<div class="col-7 col-sm-12 col-md-9">
	<nav>
	    <ul class="pagination">
	        <li class="page-item {{$paginator->onFirstPage()?'disabled':''}}"><a class="page-link" href="#" tabindex="-1" aria-disabled="true" wire:click.prevent="previousPage" style="cursor: pointer;">Previous</a></li>
	        <li class="page-item {{$paginator->hasMorePages()?'':'disabled'}}"><a class="page-link" href="#" tabindex="-1" aria-disabled="true" wire:click.prevent="nextPage" style="cursor: pointer;">Next</a></li>
	    </ul>
	</nav>            
</div>
<div class="col-5 col-sm-12 col-md-3 text-left text-md-right">
    <div class="dataTables_info" id="DataTables_Table_1_info" role="status" aria-live="polite">Page {{$paginator->currentPage()}} of {{$paginator->lastPage()}}</div>
</div>
@endif