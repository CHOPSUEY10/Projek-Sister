<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Modern Business - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100 bg-light">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            @include('layout.navbar')

            <!-- Projects Section-->
            <section class="py-5">
                <div class="container px-2 mb-5">
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Voting</span></h1>
                    </div>
                    <div class="gx-5 justify-content-center grid grid-cols-2" >
                        <div class="grid grid-cols-2" id="voteList" >
                           
                        </div>
                    </div>
                </div>
            </section>
            <!-- Call to action section-->
            <section class="py-5 bg-gradient-primary-to-secondary text-white">
                <div class="container px-5 my-5">
                    <div class="text-center">
                        <h2 class="display-4 fw-bolder mb-4">Let's build something together</h2>
                        <a class="btn btn-outline-light btn-lg px-5 py-3 fs-6 fw-bolder" href="contact.html">Contact me</a>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-white py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0">Copyright &copy; Your Website 2023</div></div>
                    <div class="col-auto">
                        <a class="small" href="#!">Privacy</a>
                        <span class="mx-1">&middot;</span>
                        <a class="small" href="#!">Terms</a>
                        <span class="mx-1">&middot;</span>
                        <a class="small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="{{asset('js/jquery-3.7.1.js')}}"></script>

        <script src="js/sweetalert2@11.js"></script>
    </body>
</html>

<script>
    let voteData = null;

    function fetchData(){
        
        $.ajaxSetup({
            headers : {
                'Authorization' : "Bearer " + window.localStorage.getItem("api-key") ,
                'Content-Type' : 'application/json'
            }
        });
        $.ajax({
            url : "{{$apiRoute}}/user/voting?status=active",
            success : (res)=>{
                voteData = res.data;
                $('#voteList')[0].innerHTML = "";
                res.data.forEach((d, idx)=>{
                    console.log( d.data? (d.data.candidate != null ? "disabled" : ""):"");
                    let candView = "";
                    d.candidate.forEach((cand, idx)=>{
                        candView += 
                        `<div> 
                            <center>
                            <img src="{{asset('assets/images/man.png')}}"  style="width : 100%;"> 
                            <b><h4>${cand.name}</h4></b>
                            <input type="radio" name="candidate" value="${idx}" checked="${d.data ? (d.data.candidate ? (d.data.candidate == idx ? 'checked' : '' ): 0 ) : 0 }">
                            </center>
                        </div>`;
                    });
                    console.log(d);
                    $('#voteList')[0].innerHTML  += ` <div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <div class="p-5" style="display : grid; grid-template-columns: repeat(2, calc(50% - 4rem)); column-gap : 4rem; width : 100%;);">
                                        <div>
                                            <h2 class="fw-bolder">${d.voting_name}</h2>
                                            <hr>
                                            <p>${d.description}</p>
                                            <p>Waktu mulai : ${new Date(d.voting_start).toLocaleString()}</p>
                                            <p>Waktu berakhir : ${new Date(d.voting_end).toLocaleString()}</p>
                                            <p>Total Suara Terkumpul : ${d.data ? d.data.voteCount ?? 0 : 0}</p>
                                            <br>
                                            <button class="btn btn-primary" onClick="voting('form${idx}')" ${d.data? (d.data.candidate != null ? "disabled" : ""):""}>${d.data? (d.data.candidate != null ? "Anda sudah vote" : "Vote"):"Vote"}</button>
                                        </div>

                                        <div>
                                            <h3 class="fw-bolder">Kandidat/Calon</h2>
                                            <form id="form${idx}" enctype="multipart/form-data">
                                                <input name="voting_id" type="text"  hidden value="${d.id}">
                                                <div class="mt2" style="margin-top : 2rem;display: flex; column-gap : 1rem;">
                                                ${candView}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>`;
                });
            },
            error : (err)=>{

            }
        });
    }


    function voting(id){
        var object = {};
        new FormData($(`#`+id)[0]).forEach((value, key) => object[key] = value);
        Swal.fire({
            title: `Lakukan voting untuk kandidat ke-${parseInt(object.candidate)+1} ?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Ya',
            denyButtonText: 'Tidak',
            customClass: {
              actions: 'my-actions',
              cancelButton: 'order-1 right-gap',
              confirmButton: 'order-2',
              denyButton: 'order-3',
            },
          }).then((result) => {
            if (result.isConfirmed) {
                var json = JSON.stringify(object);

                $.ajaxSetup({
                    headers : {
                        'Authorization' : "Bearer " + window.localStorage.getItem("api-key") ,
                        'Content-Type' : 'application/json'
                    }
                });
                
                $.ajax({
                    url : "{{$apiRoute}}/voting",
                    method : "PATCH",
                    data : json,
                    success : (res)=>{
                        Swal.fire({
                            icon : res.status == 200 ? "success" : "error",
                            text  : res.message,
                            title : res.status == 200 ? "Berhasil" : "Gagal",
                        });

                        fetchData();
                    },
                    error : (err)=>{
                        Swal.fire({
                            icon :  "error",
                            text  : err.responseJSON.message,
                            title : "Error",
                        });
                    }
                });

            } else if (result.isDenied) {
              Swal.fire('Aksi dibatalkan', '', 'info')
            }
          })
        
    }

    fetchData();
</script>
