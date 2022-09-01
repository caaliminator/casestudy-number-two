<?php
    require_once("phpfiles/connection.php");

    function getData($conn)
    {
        $stmt = $conn->query("SELECT b.base_id, b.base_name, COUNT(m.base_id) AS members FROM base AS b LEFT JOIN martian AS m ON b.base_id = m.base_id GROUP BY b.base_id");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    }


    function getMembersBase($conn, $id)
    {   
        $stmt = $conn->query("SELECT * FROM martian WHERE base_id=$id");
        
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    }

    function getAllMartians($conn)
    {   
        $stmt = $conn->query("SELECT m.martian_id, m.first_name, m.last_name, b.base_name FROM martian AS m RIGHT JOIN base AS b ON m.base_id = b.base_id ORDER BY martian_id ASC");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    }
    
    function getMartianSuperior($conn)
    {   
        $stmt = $conn->query("SELECT mc.martian_id, mc.first_name, mc.last_name, CONCAT(mt.first_name, ' ', mt.last_name) as Superior FROM martian_confidential as mc INNER JOIN martian as mt ON mc.super_id = mt.martian_id");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    }

    
    function getAllSupply($conn)
    {   
        $stmt = $conn->query("SELECT base.base_name, supply.name, inventory.quantity FROM base JOIN inventory ON base.base_id = inventory.base_id JOIN supply ON inventory.supply_id = supply.supply_id");
        $arr = array();
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            array_push($arr,$row);
        }
        echo json_encode($arr);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CAALIM | CENTINO | MAPALO
        | Case Study 2 - Mars Mission </title>
    <link rel="icon" href="assets/img/astro-icon.png">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        .base-img {
            background-color: green;
            transition: transform .2s;
            margin: 0 auto;
        }

        .base-img:hover {
            transform: scale(1.5); 
        }
    </style>
</head>
<body>
    <!-- NAVIGATION BAR STARTS HERE -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00557c;">
        <div class="container-fluid" style="padding-left:50px; padding-right:100px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" ></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <br>
                <a style="color:white;font-weight:600;" class="navbar-brand" href="#">
                    <img src="assets/img/astro-icon.png" class="img-fluid" alt="Responsive image" style="height:40px;">
                    <span> Martian Mission </span>
                </a>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a style="color:white;font-weight:600;" class="nav-link"  href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, Martians!
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a style="color:white;font-weight:600;" class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"> Home </a></li>
                            <li><a class="dropdown-item" href="#"> Status </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-end">
        <button id="genReport" type="button" class="btn btn-primary btn-sm btn-block" style="margin-right:60px;margin-top:20px;background-color:#00557c">
            <img style="height:25px;" src="assets/img/btn-report.png" class="img-fluid base-img" alt="2">
            &nbsp;
            Generate Report 
            &nbsp;
        </button>
    </div>

    <div class="container-fluid mt-2">
        <div class="mt-4 p-5 rounded"  >
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-around">
                        <div class="col-lg-2">
                            <div class="card ">
                                <h6 class="card-header" style="text-align: center;" id="baseName01">  </h6>
                                <div class="card-body">
                                    <img id="viewBaseMembers" src="assets/img/base-pics/1.jpg" class="img-fluid base-img" alt="1">
                                    <hr>
                                    <span class="d-flex justify-content-center text-primary">
                                        <img id="viewBaseMembers" src="assets/img/member-icon.png" class="img-fluid" alt="1" style="height:40px;">
                                        <strong id="base01"></strong> 
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="card">
                                <h6 class="card-header" style="text-align: center;" id="baseName02">  </h6>
                                <div class="card-body">
                                    <img id="viewBaseMembers" src="assets/img/base-pics/2.jpg" class="img-fluid base-img" alt="2">
                                    <hr>
                                    <span class="d-flex justify-content-center text-primary">
                                        <img id="viewBaseMembers" src="assets/img/member-icon.png" class="img-fluid" alt="2" style="height:40px;">
                                        <strong id="base02"></strong> 
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="card">
                                <h6 class="card-header" style="text-align: center;" id="baseName03"> </h6>
                                <div class="card-body">
                                    <img id="viewBaseMembers" src="assets/img/base-pics/3.jpg" class="img-fluid base-img" alt="3">
                                    <hr>
                                    <span class="d-flex justify-content-center text-primary">
                                        <img id="viewBaseMembers" src="assets/img/member-icon.png" class="img-fluid" alt="3" style="height:40px;">
                                        <strong id="base03"></strong> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-2">
                            <div class="card">
                                <h6 class="card-header" style="text-align: center;" id="baseName04">   </h6>
                                <div class="card-body">
                                    <img id="viewBaseMembers" src="assets/img/base-pics/4.jpg" class="img-fluid base-img" alt="4">
                                    <hr>
                                    <span class="d-flex justify-content-center text-primary">
                                        <img id="viewBaseMembers" src="assets/img/member-icon.png" class="img-fluid" alt="4" style="height:40px;">
                                        <strong id="base04"></strong> 
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="card">
                                <h6 class="card-header" style="text-align: center;" id="baseName05">  </h6>
                                <div class="card-body">
                                    <img id="viewBaseMembers" src="assets/img/base-pics/5.jpg" class="img-fluid base-img" alt="5">
                                    <hr>
                                    <span class="d-flex justify-content-center text-primary" >
                                        <img id="viewBaseMembers" src="assets/img/member-icon.png" class="img-fluid" alt="5" style="height:40px;">
                                        <strong id="base05"></strong> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
      </div>


    <!-- Modal -->
    <div class="modal fade" id="viewMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Members</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col"> ID </th>
                    <th scope="col"> First Name </th>
                    <th scope="col"> Last Name </th>
                    <th scope="col"> Action </th>
                </tr>
                </thead>
                <tbody id="tbl_body">
                
                </tbody>

            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewGenerateReport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Generate Reports </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:10px;">
                    <!--
                    <button id="viewMemberBases" type="button" class="btn btn-primary btn-sm btn-block" style="background-color:#00557c;margin-bottom: 5px;"> 
                        <img src="assets/img/base-icon.png" class="img-fluid" alt="5" style="height:20px;">
                        &nbsp; Bases 
                    </button>
                    -->
                    <button id="viewMemberSuperior" type="button" class="btn btn-primary btn-sm btn-block" style="background-color:#00557c;margin-bottom: 5px;"> 
                        <img src="assets/img/superior-icon.png" class="img-fluid" alt="5" style="height:20px;">
                        &nbsp; Superior 
                    </button>
                    <button id="viewSupply" type="button" class="btn btn-primary btn-sm btn-block" style="background-color:#00557c;">
                        <img src="assets/img/supply-icon.png" class="img-fluid" alt="5" style="height:20px;">
                        &nbsp; Supplies
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="viewMemberBasesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Members </h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col"> ID </th>
                    <th scope="col"> First Name </th>
                    <th scope="col"> Last Name </th>
                    <th scope="col"> Bases </th>
                </tr>
                </thead>
                <tbody id="tbl_body">
                
                </tbody>

            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewMemberSuperiorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Superiors</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col"> ID </th>
                    <th scope="col"> First Name </th>
                    <th scope="col"> Last Name </th>
                    <th scope="col"> Superior </th>
                </tr>
                </thead>
                <tbody id="tbl_bodyAllSuperior">
                
                </tbody>

            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="viewSupplyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Supplies </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"> Base Name </th>
                    <th scope="col"> Supply </th>
                    <th scope="col"> Quantity </th>
                </tr>
                </thead>
                <tbody id="tbl_bodyAllSupply">
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addMartianModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
            <div class="modal-header text-white" style="background-color:#00557c;">
                <h5 class="modal-title" id="exampleModalLabel"> Supplies </h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="firstName"> First Name </label>
                        <input type="text" class="form-control" id="firstName" name="firstName" aria-describedby="last name" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label for="lastName"> First Name </label>
                        <input type="text" class="form-control" id="lastName" name="lastName" aria-describedby="last name" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="base"> Superior </label>
                        <select class="form-control" id="superior" name="superior">
                            <option value="1">  Ray Bradbury </option>
                            <option value="8">  Mark Watney  </option>
                            <option value="10"> Chris Beck   </option>
                            <option value="12"> Elon Musk    </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="base"> Base </label>
                        <select class="form-control"  id="base" name="base">
                            <option value="1">  Tharsisland </option>
                            <option value="2">  Valles Marineris 2.0  </option>
                            <option value="3"> Gale Cratertown   </option>
                            <option value="4"> New New New York    </option>
                            <option value="5"> Olympus Mons Spa & Casino    </option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button id="submitBtn" type="button" class="btn text-white" style="background-color:#00557c;" > Submit </button>
            <button type="button" class="btn text-white" style="background-color:#00557c;" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-end">
        <button id="addMartian" type="button" class="btn btn-primary btn-sm btn-block" style="margin-right:60px;margin-top:20px;background-color:#00557c">
            +
            &nbsp;
            Add Martian
            &nbsp;
        </button>
    </div>

    <div class="container-fluid mt-2">
        <div class="mt-4 p-5 rounded"  >
            <div class="card">
                <div class="card-body">
                <table class="table">
                <thead>
                <tr>
                    <th scope="col"> ID </th>
                    <th scope="col"> First Name </th>
                    <th scope="col"> Last Name </th>
                    <th scope="col"> Bases </th>
                </tr>
                </thead>
                <tbody id="tbl_bodyAllMartians">
                
                </tbody>

            </table>
                </div>
            </div>
        </div>
    </div>
      <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>

    $(document).ready(function(){
        function populateTable() {
            data = <?php getData($conn); ?>;
            for (var i = 0; i < data.length; i++) {
                v = 1 + i;
                $("#baseName0"+v).text(data[i]['base_name']);
                $("#base0"+v).text(data[i]['members']);
            }


            rData = <?php getAllMartians($conn); ?>;
            $("#tbl_bodyAllMartians").empty();
            rData.forEach((d) => {
            $("#tbl_bodyAllMartians").append(
                    `<tr>
                    <td>${d.martian_id}</td>
                    <td>${d.first_name}</td>
                    <td>${d.last_name}</td>
                    <td>${d.base_name}</td>
                    </tr>`
                )
            });
        }
        
        
        $(document).on("click", "#viewBaseMembers", function() {
            var alt = $(this).attr("alt");

            var rData = [];
            if (alt == "1") {
                rData = <?php getMembersBase($conn, $id = 1); ?>;
            } else if (alt == "2") {
                rData = <?php getMembersBase($conn, $id = 2); ?>;
            } else if (alt == "3") {
                rData = <?php getMembersBase($conn, $id = 3); ?>;
            } else if (alt == "4") {
                rData = <?php getMembersBase($conn, $id = 4); ?>;
            } else {
                rData = <?php getMembersBase($conn, $id = 5); ?>;
            }

                $("#tbl_body").empty();
                rData.forEach((d) => {
                    $("#tbl_body").append(
                        `<tr>
                        <td>${d.martian_id}</td>
                        <td>${d.first_name}</td>
                        <td>${d.last_name}</td>
                        <td> 
                            <button type="button" class="btn btn-sm btn-outline-primary"> UPDATE </button> 
                            <button value="${d.martian_id}" type="button" class="btn btn-sm btn-outline-danger" id="delBtn">  DELETE  </button>
                        </td>
                        </tr>`
                    )
                });

            $("#viewMemberModal").modal('show');
        });



        $(document).on("click", "#genReport", function(){
            $("#viewGenerateReport").modal('show');
        });
        

        $(document).on("click", "#addMartian", function(){
            $("#addMartianModal").modal('show');
        });

        $(document).on("click", "#viewMemberSuperior", function(){
            $("#viewGenerateReport").modal('hide');


            var rData = <?php getMartianSuperior($conn); ?>;
            $("#tbl_bodyAllSuperior").empty();
            rData.forEach((d) => {
            $("#tbl_bodyAllSuperior").append(
                    `<tr>
                    <td>${d.martian_id}</td>
                    <td>${d.first_name}</td>
                    <td>${d.last_name}</td>
                    <td>${d.Superior}</td>
                    </tr>`
                )
            });

            $("#viewMemberSuperiorModal").modal('show');
        });

        $(document).on("click", "#viewSupply", function(){
            $("#viewGenerateReport").modal('hide');

            var rData = <?php getAllSupply($conn); ?>;
            $("#tbl_bodyAllSupply").empty();
            rData.forEach((d) => {
            $("#tbl_bodyAllSupply").append(
                    `<tr>
                    <td>${d.base_name}</td>
                    <td>${d.name}</td>
                    <td>${d.quantity}</td>
                    </tr>`
                )
            });

            $("#viewSupplyModal").modal('show');
        });



        $(document).on("click", "#delBtn", function(e){
            var vlu = $(this).val();
            console.log(vlu);

            $.ajax({
                url: "phpfiles/deleteData.php",
                type: 'POST',
                data:{
                martianID: vlu

                }
            })
            .done(function(data){

                
                location.reload();
                
            });

        });



        $(document).on("click", "#submitBtn", function(e){
          insertData();

          var x = $('#firstName').val();

          e.preventDefault();
        });

        function insertData() {
          $.ajax({
            url: "phpfiles/insertData.php",
            type: 'POST',
            data:{
              FirstName: $('#firstName').val(),
              LastName: $('#lastName').val(),
              Superior: $('#superior').val(),
              Base: $('#base').val()

            }
          })
          .done(function(data){
            var d = JSON.parse(data);
            console.log(d);
            var len = d.length;
            if (d == "Empty") {
              swal({
                title: "Ooppps!",
                text: "Empty field/s!",
                icon: "warning",
                button: "OK",
              });
            } else {
              swal({
                title: "Successful!",
                text: "You just inserted a data.",
                icon: "success",
                button: "Close",
              });
              $("#tbl_bodyAllMartians").append(
                `<tr>
                <td> `+ d[len-1]['martian_id'] +`</td>
                <td> `+ d[len-1]['first_name'] +`</td>
                <td> `+ d[len-1]['last_name'] +`</td>
                <td> `+ d[len-1]['base_name'] +`</td>
                </tr>`
              )
              $('input').val('');
            }
          });
        }



    populateTable();

    });






    </script>



</body>
</html>