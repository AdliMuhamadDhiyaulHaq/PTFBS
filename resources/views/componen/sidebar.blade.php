<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <table>
                    <tr>
                        <td class="mb-5">
                            <img src="mazer/assets/images/bg/bgR.png" style="width: 30px; height:30px">
                        </td>
                        <td class="text-primary fw-bold" style="font-size:20px; height:15px">
                            PT.FBS
                        </td>
                    </tr>
                </table>


            </div>

        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item  ">
                    <a href="scan-active" class='sidebar-link'>
                        <i class="bi bi-qr-code"></i>
                        <span>Scan active</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="scan-inactive" class='sidebar-link'>
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Scan inactive</span>
                    </a>
                </li>

                <li class="sidebar-item  ">
                    <a href="rekap" class='sidebar-link'>
                        <i class="bi bi-file-earmark-break"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var currentUrl = window.location.pathname; // Mendapatkan path URL saat ini
                var sidebarItems = document.querySelectorAll(".sidebar-item"); // Memilih semua item sidebar

                sidebarItems.forEach(function(item) {
                    var link = item.querySelector(".sidebar-link"); // Memilih link di dalam setiap item sidebar
                    var href = link.getAttribute("href"); // Mendapatkan atribut href dari link

                    // Memeriksa apakah path URL saat ini sesuai dengan href dari link
                    if (currentUrl.includes(href)) {
                        item.classList.add("active"); // Menambahkan kelas active jika sesuai
                    }
                });
            });
        </script>



    </div>

</div>
