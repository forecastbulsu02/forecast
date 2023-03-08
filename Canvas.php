<nav   class="navbar navbar-expand-lg navbar-dark bg-danger   shadow fixed-top">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasWithBackdrop">
        <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
    </button>
    <div class="row  ms-3 ms-lg-auto   m-0 pe-0 pe-md-3">
        <div class="col-12 p-0 pe-3">
            <form id="logout">
                <input type="text" hidden value="false" id="isLogout" name="isLogout">
                <button class="btn text-white fw-bold" ><span class="me-2 mt-5"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                        </svg>
                    </span >Logout</button>
            </form>
        </div>
                    
    </div>
</nav>

<div class="offcanvas offcanvas-start sidebar-nav bg-danger-2" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header d-flex  d-lg-none justify-content-end align-items-center">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">    
        <nav class="navbar-dark">
            <ul class="navbar-nav mt-4">
                    <li>
                        <a  class="nav-link px-3 active_admin">
                            <span class="me-2 h5"><i class="bi bi-speedometer2"></i></span>
                            <span>Superadmin</span>
                        </a>
                    </li>
                    <li class=" "><hr class="dropdown-divider bg-light" /></li>
                    <li class="mt-4">
                        <a class="nav-link px-3 <?php echo $page == "typhoon" ? "active":"" ?> sidebar-link text-white"  href="Typhoon.php">
                            <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-drizzle" viewBox="0 0 16 16">
                                <path d="M4.158 12.025a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm6 0a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm-3.5 1.5a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm6 0a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm.747-8.498a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 11H13a3 3 0 0 0 .405-5.973zM8.5 2a4 4 0 0 1 3.976 3.555.5.5 0 0 0 .5.445H13a2 2 0 0 1 0 4H3.5a2.5 2.5 0 1 1 .605-4.926.5.5 0 0 0 .596-.329A4.002 4.002 0 0 1 8.5 2z"/>
                                </svg>
                            </span>
                            <span>Typhoon</span>
                            <span class="ms-auto">
                            </span>
                        </a>
                    </li>
                    <li class="mt-4">
                        <a class="nav-link px-3 <?php echo $page == "flood" ? "active":"";  ?> sidebar-link text-white" href="Flood.php">
                            <span class="me-2">
                                <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                </span>
                                <span>Flood</span>
                                <span class="ms-auto">
                            </span>
                        </a>
                    </li>
                    <li class="mt-4">
                        <a class="nav-link px-3 <?php echo $page == "class" ? "active":"";  ?> sidebar-link text-white" href="Class.php">
                            <span class="me-2">
                                <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                </span>
                                <span>Class Suspension</span>
                                <span class="ms-auto">
                            </span>
                        </a>
                    </li>
                  
                </ul>
        </nav>
    </div>
</div>
<script>

$(document).ready(function () {
    $("#logout").on('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Golden West College?',
                        text: "Are you sure want to logout this session?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#isLogout").val("true")
                                    if(  $("#isLogout").val() === "true"){   
                                    
                                        $.ajax({
                                            type:"POST",
                                            url:"Script.php",
                                            data: new FormData(this),
                                            dataType:'json',
                                            contentType: false,
                                            cache:false,
                                            processData:false,
                                            success:function(res){
                                                if(res == "SUCCESS"){
                                                    Swal.fire({
                                                        title: 'Golden West College',
                                                        text: "Logout successfull!",
                                                        icon: 'success',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    }).then(()=>{
                                                        window.location.href="index.php";
                                                    })
                                                }else{
                                                    Swal.fire({
                                                        title: 'Golden West College',
                                                        text: "Database: "+res,
                                                        icon: 'error',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    }).then(()=>{
                                                    })
                                                }
                                            }
                                        });
                                        $("#isLogout").val("false")
                                    }
                            }
                        })
                    })

});
</script>
