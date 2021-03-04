<style>
    .clickable-row {
        color: white;
        background-color: #007bff;
        cursor: pointer;
    }
</style>
<div class="icon-bar" style="position: fixed; right: 55px; bottom: 70px; z-index: 99;">
    <div class="collapse" id="collapseExample">
        <ul style="list-style: none">
            <table class="table table-borderless" style="border-collapse: separate; border-spacing:0 15px;">
                <tbody>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Tasks" data-href='{{route('admin.tasks.index')}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;"  class="fa fa-tasks fa-lg"></i> </td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Projects" data-href='{{route('admin.tasks.index')}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;"  class="fa fa-project-diagram fa-md"></i> </td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Followup-Lead" data-href='{{route('admin.followUps.index', ['followableType' => 'lead'])}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;"  class="fa fa-random fa-lg"></i></td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Followup-Clientele" data-href='{{route('admin.followUps.index', ['followableType' => 'clientele'])}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;"  class="fa fa-random fa-lg"></i></td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Email" data-href='{{route('admin.emailTemplates.index')}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;"  class="fas fa-envelope-square fa-lg"></i></td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Clientele" data-href='{{route('admin.clienteleManagements.create')}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: left;" class="fa fa-handshake-o fa-lg"></i></td>
                </tr>
                <tr class='clickable-row' data-toggle="tooltip" data-placement="left" title="Leads" data-href='{{route('admin.leads.create')}}'>
                    <td style="border-radius: 45px;
            text-align: center;
            justify-content: center;
            align-items: center;
            vertical-align: middle;"><i style="color: white; text-align: center;" class="fa fa-bolt fa-lg"></i></td>
                </tr>
                </tbody>
            </table>
        </ul>
    </div>
    <p class="d-flex justify-content-center align-items-center">
        <a class="btn btn-primary" style="position: fixed; right: 50px; bottom: 30px;
                   background-color: #007bff; color: #fff; z-index: 1000; border-radius: 50%; padding: 13px 14px;"
           data-toggle="collapse" href="#collapseExample">
            <i class="fas fa-plus fa-2x"></i>
        </a>
    </p>
</div>


@push('stackedScripts')
    <script>
        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
