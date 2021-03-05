{!! (new \App\Http\Controllers\Admin\SideBarMenuController())->getSidebar() !!}

@push('stackedScripts')
    <script>
        $(document).ready(function () {
            //Add active/menu-opne to the parent of current active element
            let a = $('a.nav-link.active');
            $(a[0]).parents().parent().parent().addClass('menu-open');
            $(a[0]).parents().parent().prev().addClass('active');

            //Remove empty route group
            $('ul.nav.nav-treeview').each(function(){
                if($(this).find('li').length === 0){
                    $(this).parent().remove();
                }
            });

            //Remove header which has not any routes/route group
            $('li.nav-header').each(function(){
                if(!$(this).next().hasClass('nav-item')){
                    $(this).remove();
                }
            });
        });
    </script>
@endpush

