<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Admin Dashboard';

//TODO: We need to load an admin-specific header.
ViewHelper::loadAdminHeader($page_title);


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Share
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Export
                </button>
            </div>
            <button
                type="button"
                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi" aria-hidden="true">
                    <use xlink:href="#calendar3"></use>
                </svg>
                This week
            </button>
        </div>
    </div>
    <canvas
        class="my-4 w-100"
        id="myChart"
        width="900"
        height="380"></canvas>
    <h2>Section title</h2>
    <div class="table-responsive small">
        <table id="example-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Header</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1,001</td>
                    <td>random</td>
                    <td>data</td>
                    <td>placeholder</td>
                    <td>text</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,002</td>
                    <td>placeholder</td>
                    <td>irrelevant</td>
                    <td>visual</td>
                    <td>layout</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,003</td>
                    <td>data</td>
                    <td>rich</td>
                    <td>dashboard</td>
                    <td>tabular</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,003</td>
                    <td>information</td>
                    <td>placeholder</td>
                    <td>illustrative</td>
                    <td>data</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,004</td>
                    <td>text</td>
                    <td>random</td>
                    <td>layout</td>
                    <td>dashboard</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,005</td>
                    <td>dashboard</td>
                    <td>irrelevant</td>
                    <td>text</td>
                    <td>placeholder</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,006</td>
                    <td>dashboard</td>
                    <td>illustrative</td>
                    <td>rich</td>
                    <td>data</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,007</td>
                    <td>placeholder</td>
                    <td>tabular</td>
                    <td>information</td>
                    <td>irrelevant</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,008</td>
                    <td>random</td>
                    <td>data</td>
                    <td>placeholder</td>
                    <td>text</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,009</td>
                    <td>placeholder</td>
                    <td>irrelevant</td>
                    <td>visual</td>
                    <td>layout</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,010</td>
                    <td>data</td>
                    <td>rich</td>
                    <td>dashboard</td>
                    <td>tabular</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,011</td>
                    <td>information</td>
                    <td>placeholder</td>
                    <td>illustrative</td>
                    <td>data</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,012</td>
                    <td>text</td>
                    <td>placeholder</td>
                    <td>layout</td>
                    <td>dashboard</td>
                </tr>
                <tr>
                    <td>1,013</td>
                    <td>dashboard</td>
                    <td>irrelevant</td>
                    <td>text</td>
                    <td>visual</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,014</td>
                    <td>dashboard</td>
                    <td>illustrative</td>
                    <td>rich</td>
                    <td>data</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>1,015</td>
                    <td>random</td>
                    <td>tabular</td>
                    <td>information</td>
                    <td>text</td>
                    <td>
                        <form action="/upload" method="POST" enctype="multipart/form-data">
                            <label for="upload-example">Select a file to upload:</label>
                            <input type="file" name="upload-example" id="upload-example">
                            <input type="submit" value="Upload File">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<?php

ViewHelper::loadJsScripts();
//TODO: We need to load an admin-specific footer.
ViewHelper::loadAdminFooter();
?>
