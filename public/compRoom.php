<?php
    include('header.php');
?>

<script src="js/jquery.tablesorter.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myTable").tablesorter({sortList: [[1,0]]});
    
        $('#shutdown').on('show.bs.modal', function (e) {
            mac = e.relatedTarget.id;
            hostname = e.relatedTarget.dataset.hostname;
            $('#btnShutdown').click(function (p) {
                if($("#inputUsername").val()!="") {
                    username = $("#inputUsername").val();
                }
                else {
                    username = $("#inputUsername").attr('placeholder');
                }
                compStartStop("Stop", e.relatedTarget.id, e.relatedTarget.dataset.hostname, username, $("#inputPassword").val());
                $("#inputPassword").val("");
            });
        });
        $('.btnStart').click(function (p) {
            compStartStop("Start", p.target.id, p.target.dataset.hostname)
        });
        $('.btnStartAll').click(function (p) {
            compStartStop("StartAll", p.target.dataset.room)
        });
        $('.btnStopAll').click(function (p) {
            compStartStop("StopAll", p.target.dataset.room)
        });
        $('a, button').click(function() {
            $(this).toggleClass('active');
        });
    });
</script>
<?php if ($config['internet'] && inGroup('internet') && $config['rooms'][$roomId]['internet']) { ?>
    <div class="container">
        <div class="jumbotron text-center">
            <h2>Internet</h2>
            <a id="netstartstopbt" class="btn btn-default btn-info" data-stat="get" data-room="<?=$roomId?>" onclick="netstartstop(this)">Get status</a>
        </div>
    </div>
<?php } ?>
    <div class="container">
    <div class="row">
    <div class="span6">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered table-condensed tablesorter">
        <thead>
                <tr class="warning">
                        <th>Info</th>
                        <th>Computer name</th>
                        <th>Status</th>
                        <th>Action</th>
                </tr>
        </thead>
        <tbody>
<?php
    $url = "../server/computers.json";
    $json = file_get_contents($url);
    $computers = json_decode($json, TRUE);

    foreach($computers as $comp => $compVal) {
    if ($roomId == "all" && inGroup('admin')) {
                printTableRow($compVal, $config, $roomId);
            }
         else {
            if ((($compVal['room'] == $roomId) && inGroup($roomId)) || (($compVal['room'] == $roomId) && inGroup('admin')) || (($compVal['room'] == $roomId) && (!$config['autentication']) && inGroup($roomId, 'guest'))) {
                printTableRow($compVal, $config, $roomId);
        }
    }
    }
?>		
            </tbody>
            <?php if ($config['startstopall'] && (inGroup('admin') || inGroup($roomId)) && ($config['rooms'][$roomId]['poweronall'] || $config['rooms'][$roomId]['poweroffall'])) { ?>
            <tfoot>
                <tr class="active">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                    <?php
                        if ($config['rooms'][$roomId]['poweronall']) {
                            echo '<button id="startAll" data-room="'.$roomId.'" class="btnStartAll btn btn-success btn-xs">StartAll</button>';}
                        if ($config['rooms'][$roomId]['poweroffall']) {
                            //echo '<button id="stopAll" data-room="'.$roomId.'" class="btnStopAll btn btn-danger btn-xs" data-toggle="modal" data-target="#shutdown">StopAll</button>';}
                            echo '<button id="stopAll" data-room="'.$roomId.'" class="btnStopAll btn btn-danger btn-xs">StopAll</button>';}
                    ?>
                    </th>
                </tr>
            </tfoot>
            <?php } ?>
            </table>
	</div>
	</div>
	</div>
	</div>

<?php
    include('footer.php');
?>

<div class="modal fade" id="shutdown" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Shutdown form</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="username" class="form-control" id="inputUsername" placeholder="<?=$_SESSION["username"]?>">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a id="btnShutdown" class="btn btn-danger" data-dismiss="modal">Shutdown</a>
                    <a class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
              </div>
            </form>
            </div>
        </div>
    </div>
</div>