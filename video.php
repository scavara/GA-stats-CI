<i href="/SET_PROPER_VIEW_LOCATION/gastats" type="button" data-toggle="modal" data-target="#my_modal" class="fa fa-bar-chart fa-lg fa-fw" style='cursor: pointer'></i>
<!-- Modal -->
<style>
    /* Table 1 Style */
    table.table1 {
        font-family: "Trebuchet MS", sans-serif;
        font-size: 16px;
        font-weight: bold;
        line-height: 1.4em;
        font-style: normal;
        border-collapse: separate;
        margin-left: auto;
        margin-right: auto;
    }

    .table1 thead th {
        padding: 15px;
        color: #fff;
        text-shadow: 1px 1px 1px #568F23;
        border: 1px solid #93CE37;
        border-bottom: 3px solid #9ED929;
        background-color: #9DD929;
        background: -webkit-gradient(
                linear,
                left bottom,
                left top,
                color-stop(0.02, rgb(123, 192, 67)),
                color-stop(0.51, rgb(139, 198, 66)),
                color-stop(0.87, rgb(158, 217, 41))
        );
        background: -moz-linear-gradient(
                center bottom,
                rgb(123, 192, 67) 2%,
                rgb(139, 198, 66) 51%,
                rgb(158, 217, 41) 87%
        );
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius: 5px 5px 0px 0px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .table1 thead th:empty {
        background: #242424;
        border: none;
    }

    .table1 tbody th:empty {
        background: #242424;
        border: none;
    }

    .table1 tbody td:empty {
        background: #242424;
        border: none;
    }

    .table1 tbody th {
        color: #fff;
        text-shadow: 1px 1px 1px #568F23;
        background-color: #9DD929;
        border: 1px solid #93CE37;
        border-right: 3px solid #9ED929;
        padding: 0px 10px;
        background: -webkit-gradient(
                linear,
                left bottom,
                right top,
                color-stop(0.02, rgb(158, 217, 41)),
                color-stop(0.51, rgb(139, 198, 66)),
                color-stop(0.87, rgb(123, 192, 67))
        );
        background: -moz-linear-gradient(
                left bottom,
                rgb(158, 217, 41) 2%,
                rgb(139, 198, 66) 51%,
                rgb(123, 192, 67) 87%
        );
        -moz-border-radius: 5px 0px 0px 5px;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-bottom-left-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .table1 tbody td {
        padding: 10px;
        text-align: center;
        background-color: #DEF3CA;
        border: 2px solid #E7EFE0;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        color: #f78a39;
        text-shadow: 1px 1px 1px #fff;
    }

    output {
        display: inline;
        color: #f78a39;
        font-size: 100%;
    }

    .div-modal-body {
        color: #f78a39;
        text-align: center;
    }

    .div-modal {
        background-color: #242424;
    }

    .div-modal-header {
        background-color: #242424;
    }

    .modal-close {
        color: #f78a39;
        cursor: pointer;
        float: left;
    }

    .div-modal-footer {
        color: #666;
        font-size: small;
    }
</style>
<div id="my_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content div-modal">
            <div class="modal-body div-modal-body">
                <i class="fa fa-times modal-close" data-dismiss="modal"></i>
                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            </div>
            <div class="modal-footer div-modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
