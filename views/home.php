
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Easy Location - Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    </head>

    <style>
        .container-fluid {
            max-width: 1280px;
        }

        .text-ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .w-100 {
            min-width: 100px;
        }

        .margin-left-8 {
            margin-right: 8px;
        }
    </style>
<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-5">
        <div class="container-fluid">
            <a href="/home" class="navbar-brand">EasyLocation</a>
            <div class="collapse navbar-collapse mx-auto">
                <div class="navbar-nav mx-auto">
                    <form class="d-flex" method="get" action="/home">
                        <div class="input-group">
                            <select name="orderBy" class="form-select" style="max-width: 150px">
                                <option value="proximity">Proximity</option>
                                <option value="pricepernight">Price</option>
                            </select>

                            <input type="text" name="coords" class="form-control" id="coordsInput" value="" />

                            <button class="btn btn-outline-light" type="button" id="findLocationBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                            </button>
                            <button class="btn btn-outline-light" style="width: 150px" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex">
                <button class="btn btn-outline-secondary w-100">Sign In</button>
            </div>
        </div>
    </nav>



    <div class="container-fluid">


        <?php if (isset($items) && count($items)): ?>

            <div class="row">
              <?php foreach ($items as $location): ?>
                <div class="col-md-3">
                    <div class="card mb-5" style="width: 18rem;">
                        <img src="https://dummyimage.com/300x300/bfbfbf/4f4f4f" height="100" class="card-image-top" />
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title text-ellipsis m-0" data-bs-toggle="tooltip" data-bs-title="<?php echo $location->getName() ?>"><?php echo $location->getName() ?></h6>
                                <button class="btn btn-light btn-sm"><i class="fa fa-heart-o"></i></button>
                            </div>


                            <div class="card-text ">




                            </div>

                        </div>

                        <div class="card-footer text-muted d-flex justify-content-between">
                            <span class="badge text-lg text-bg-success"><?php echo $location->getPrice()  ?> €</span>
                            <span><?php echo $location->getDistance()  ?> KM</span>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-light text-center rounded py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#464646" class="bi mb-2 bi-funnel-fill" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
                </svg>

                <h5>No data was found.</h5>
                <p>If you're doing a search try change the filters.</p>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script>

    function registerListeners() {
        document.getElementById('findLocationBtn').addEventListener('click', requestPosition)

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    }

    function requestPosition() {
        if (navigator.geolocation) navigator.geolocation.getCurrentPosition(showPosition)
    }

    function showPosition(position) {
        document.getElementById('coordsInput').value = `${position.coords.latitude}, ${position.coords.longitude}`;
    }

    window.addEventListener("load", registerListeners)
</script>

<script src="https://use.fontawesome.com/c21dec05f5.js"></script>

</body>
</html>