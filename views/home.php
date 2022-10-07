
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Easy Location - Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    </head>
    <body>
        <nav class="navbar navbar-dark sticky-top bg-dark navbar-expand-lg mb-5">
            <div class="container-fluid">
                <a href="/home" class="navbar-brand">EasyLocation</a>
                <div class="collapse navbar-collapse mx-auto">
                    <div class="navbar-nav mx-auto">
                        <form class="d-flex" method="get" action="/home">
                            <div class="input-group">
                                <select name="orderBy" class="form-select" style="max-width: 150px">
                                    <option disabled>Select</option>
                                    <option value="proximity" <?php echo request()->get('orderBy') == 'proximity' ? 'selected' : '' ?>>Proximity</option>
                                    <option value="price" <?php echo request()->get('orderBy') == 'price' ? 'selected' : '' ?>>Price</option>
                                </select>

                                <input type="text" name="coords" class="form-control" id="coordsInput" value="<?php echo request()->get('coords') ?>" />

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
                    <button class="btn btn-outline-success w-100">Sign In</button>
                </div>
            </div>
        </nav>



        <div class="container-fluid">
            <?php if (isset($locations) && count($locations)): ?>
                <div class="row">
                  <?php foreach ($locations as $location): ?>
                    <div class="col-md-3">
                        <div class="card mb-5" style="width: 18rem;">
                            <img src="https://dummyimage.com/300x300/bfbfbf/4f4f4f" height="100" class="card-image-top" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title text-ellipsis m-0" data-bs-toggle="tooltip" data-bs-title="<?php echo $location->getName() ?>"><?php echo $location->getName() ?></h6>
                                    <button class="btn btn-light btn-sm"><i class="fa fa-heart-o"></i></button>
                                </div>
                            </div>

                            <div class="card-footer text-muted d-flex justify-content-between">
                                <span class="badge text-lg text-bg-success"><?php echo formatMoney($location->getPrice(), 'EUR')  ?></span>
                                <span><?php echo formatKM($location->getDistance())  ?></span>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>

                    <?php if (isset($pagination)): ?>
                        <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>

                                    </a>
                                </li>
                              <?php for ($page = 1; $page < $pagination['totalPages']; $page++): ?>
                                  <li class="page-item">
                                      <form action="/home" method="get">
                                        <?php if (request()->get('orderBy')): ?>
                                            <input type="hidden" name="orderBy" value="<?php echo request()->get('orderBy') ?>" />
                                        <?php endif; ?>
                                        <?php if (request()->get('coords')): ?>
                                            <input type="hidden" name="coords" value="<?php echo request()->get('coords') ?>" />
                                        <?php endif; ?>

                                          <input type="hidden" name="page" value="<?php echo $page ?>" />
                                          <button class="page-link <?php echo request()->get('page') == $page ? 'active' : request()->get('page') == null && $page == 1 ? 'active' : '' ?>""><?php echo $page ?></button>
                                      </form>
                                  </li>
                              <?php endfor; ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>

                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
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
    </body>
</html>