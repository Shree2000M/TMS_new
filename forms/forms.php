
<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'transportdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$partyDetails1 = null;
$partyDetails2 = null;

// If form is submitted, fetch the selected party details for both selects
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['party_id1'])) {
        $party_id1 = $_POST['party_id1'];
        $stmt1 = $conn->prepare("SELECT * FROM parties WHERE id = ?");
        $stmt1->bind_param("i", $party_id1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1->num_rows > 0) {
            $partyDetails1 = $result1->fetch_assoc();
        }
        $stmt1->close();
    }

    if (isset($_POST['party_id2'])) {
        $party_id2 = $_POST['party_id2'];
        $stmt2 = $conn->prepare("SELECT * FROM parties WHERE id = ?");
        $stmt2->bind_param("i", $party_id2);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            $partyDetails2 = $result2->fetch_assoc();
        }
        $stmt2->close();
    }
}

// Fetch all parties for both dropdowns
$result = $conn->query("SELECT id, name FROM parties ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Forms - Kaiadmin Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="../index.php" class="logo">
            <span class="sidebar-brand-text text-white fs-4 fw-bold">SecurX</span>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../../demo1/index.html">
                        <span class="sub-item">Dashboard 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Base</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../components/avatars.html">
                        <span class="sub-item">Avatars</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/buttons.html">
                        <span class="sub-item">Buttons</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/gridsystem.html">
                        <span class="sub-item">Grid System</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/panels.html">
                        <span class="sub-item">Panels</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/notifications.html">
                        <span class="sub-item">Notifications</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/sweetalert.html">
                        <span class="sub-item">Sweet Alert</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/font-awesome-icons.html">
                        <span class="sub-item">Font Awesome Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/simple-line-icons.html">
                        <span class="sub-item">Simple Line Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="../components/typography.html">
                        <span class="sub-item">Typography</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-th-list"></i>
                  <p>Sidebar Layouts</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../sidebar-style-2.html">
                        <span class="sub-item">Sidebar Style 2</span>
                      </a>
                    </li>
                    <li>
                      <a href="../icon-menu.html">
                        <span class="sub-item">Icon Menu</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item active submenu">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-pen-square"></i>
                  <p>Forms</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse show" id="forms">
                  <ul class="nav nav-collapse">
                    <li class="active">
                      <a href="../forms/forms.php">
                        <span class="sub-item">New Booking</span>
                      </a>
                    </li>
                    <li>
                      <a href="addparty.php">
                        <span class="sub-item">Add party</span>
                      </a>
                    </li>
                    <li>
                      <a href="addvehicle.php">
                        <span class="sub-item">Add Vehicle</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-table"></i>
                  DATA
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../tables/tables.html">
                        <span class="sub-item">Basic Table</span>
                      </a>
                    </li>
                    <li>
                      <a href="../tables/datatables.php">
                        <span class="sub-item">Booking List</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="../index.php" class="logo">
                <img
                  src="../assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-envelope"></i>
                  </a>
                  <ul
                    class="dropdown-menu messages-notif-box animated fadeIn"
                    aria-labelledby="messageDropdown"
                  >
                    <li>
                      <div
                        class="dropdown-title d-flex justify-content-between align-items-center"
                      >
                        Messages
                        <a href="#" class="small">Mark all as read</a>
                      </div>
                    </li>
                    <li>
                      <div class="message-notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="../assets/img/jm_denis.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jimmy Denis</span>
                              <span class="block"> How are you ? </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="../assets/img/chadengle.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Chad</span>
                              <span class="block"> Ok, Thanks ! </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="../assets/img/mlane.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jhon Doe</span>
                              <span class="block">
                                Ready for the meeting today...
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="../assets/img/talha.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Talha</span>
                              <span class="block"> Hi, Apa Kabar ? </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all messages<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-icon notif-primary">
                              <i class="fa fa-user-plus"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> New user registered </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-success">
                              <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Rahmad commented on Admin
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="../assets/img/profile2.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Reza send messages to you
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-danger">
                              <i class="fa fa-heart"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> Farrah liked Admin </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">Quick Actions</span>
                      <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-warning rounded-circle"
                              >
                                <i class="fas fa-map"></i>
                              </div>
                              <span class="text">Maps</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Reports</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-success rounded-circle"
                              >
                                <i class="fas fa-envelope"></i>
                              </div>
                              <span class="text">Emails</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-primary rounded-circle"
                              >
                                <i class="fas fa-file-invoice-dollar"></i>
                              </div>
                              <span class="text">Invoice</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-secondary rounded-circle"
                              >
                                <i class="fas fa-credit-card"></i>
                              </div>
                              <span class="text">Payments</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="../assets/img/profile.jpg"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">Shritej</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="../assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>Hizrian</h4>
                            <p class="text-muted">hello@example.com</p>
                            <a
                              href="profile.html"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">My Profile</a>
                        <a class="dropdown-item" href="#">My Balance</a>
                        <a class="dropdown-item" href="#">Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Forms</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Forms</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">New Booking</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Form Elements</div>
                  </div>
                  <div class="card-body">
                    <div class="container-fluid mt-4">
                      <div class="row">
                          <!-- Order Details Section -->
                          <div class="col-md-6">
                          <div class="section-card text-bg-light p-3">
                              <h5 class="section-heading">Order Details</h5>
                              <div class="row">
                                  <!-- <div class="col-md-6 mb-3">
                                      <label for="consignor" class="form-label">Consignor / Sender</label>
                                      <input type="text" class="form-control" id="consignor" name="consignor" placeholder="Enter consignor's name" required>
                                  </div> -->

                                  <div class="col-md-6 mb-3">
                                    <label for="transportMode" class="form-label">Consignor / Sender</label>
                                    <select class="form-select form-control" name="consignor" id="consignor" required>
                                    <option value="" disabled selected>Select a party</option>
                                            <?php
                                              if ($result->num_rows > 0) {
                                                 while ($row = $result->fetch_assoc()) {
                                                                   echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                                                                  }
                                                                  } else {
                                                                  echo "<option value='' disabled>No parties available</option>";
                                                         }
                                                            ?>
                                    </select>
                                </div>

                                  <div class="col-md-6 mb-3">
                                      <label for="consignee" class="form-label">Consignee / Receiver</label>
                                      <select class="form-select form-control" name="consignee" id="consignee" required>
                                    <option value="" disabled selected>Select consignee's name</option>
                                           
                <?php
                // Reset the result pointer to reuse the same query result for the second dropdown
                $result->data_seek(0); 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>No parties available</option>";
                }
                ?>
                                    </select>
                                  </div>
                                  
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label for="bookingDate" class="form-label">Booking Date</label>
                                      <input type="DATE" class="form-control" name="bookingDate" id="bookingDate" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label for="transportMode" class="form-label">Transportation Mode</label>
                                      <select class="form-select form-control" name="transportMode" id="transportMode" required>
                                          <option value="">Select mode</option>
                                          <option value="Road">Road</option>
                                          <option value="Air">Air</option>
                                          <option value="Sea">Sea</option>
                                          <option value="Rail">Rail</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label for="fromLocation" class="form-label">From Location</label>
                                      <input type="text" class="form-control" name="fromLocation" id="fromLocation" placeholder="Starting location" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label for="toLocation" class="form-label">To Location</label>
                                      <input type="text" class="form-control" name="toLocation" id="toLocation" placeholder="Destination" required>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label for="paidBy" class="form-label">Paid By (Bill To)</label>
                                      <select class="form-select form-control" name="paidBy" id="paidBy" required>
                                          <option value="">Select</option>
                                          <option value="Consignor">Consignor</option>
                                          <option value="Consignee">Consignee</option>
                                          <option value="Third Party">Third Party</option>
                                      </select>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label for="taxPaidBy" class="form-label">Tax Paid By</label>
                                      <select class="form-select form-control" name="taxPaidBy" id="taxPaidBy" required>
                                          <option value="">Select</option>
                                          <option value="Consignor">Consignor</option>
                                          <option value="Consignee">Consignee</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label for="pickupAddress" class="form-label">Pickup Address</label>
                                  <textarea class="form-control" name="pickupAddress" id="pickupAddress" rows="2" placeholder="Enter pickup address" required></textarea>
                              </div>
                              <div class="mb-3">
                                  <label for="deliveryAddress" class="form-label">Delivery Address</label>
                                  <textarea class="form-control" name="deliveryAddress" id="deliveryAddress" rows="2" placeholder="Enter delivery address" required></textarea>
                              </div>
                          </div>
                          <div class="section-card text-bg-light p-3">
                                          <h6 class="mb-3">Total Charges</h6>
                                          <table class="table table-sm">
                                              <tr>
                                                  <th>Total Item Charges</th>
                                                  <td name="totalItemCharges" id="totalItemCharges">0.00</td>
                                              </tr>
                                              <tr>
                                                  <th>Total Additional Charges</th>
                                                  <td name="totalAdditionalCharges" id="totalAdditionalCharges">0.00</td>
                                              </tr>
                                              <tr>
                                                  <th><strong>Total Bill</strong></th>
                                                  <td name="totalBill" id="totalBill">0.00</td>
                                              </tr>
                                          </table>
                                      </div>
                                      
                      
                          <!-- Submit Button -->
                          <!-- <div class="section-card text-center">
                              <button type="button" class="btn btn-primary w-50" onclick="submitData()">Submit All</button>
                          </div> -->
                          </div>
                          
                      <!-- Vehicle details -->
                      <div class="col-md-6">
                          <div class="section-card text-bg-light p-3">
                              <h5 class="section-heading">Vehicle Details</h5>
                              <div class="row">
                                  
                                  <div class="col-md-6 mb-3">
                                      <label for="transportMode" class="form-label">Vehicle Type</label>
                                      <select class="form-select form-control" name="vehicletype" id="vehicletype" required>
                                          <option value="">Select Vehicle</option>
                                          <option value="Road">Truck</option>
                                          <option value="Air">Bus</option>
                                          <option value="Sea">Pick-Up</option>
                                          <option value="Rail">Other</option>
                                      </select>

                                      

                                  </div>
                                  
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label for="consignor" class="form-label">Vehicle Capecity</label>
                                      <input type="text" class="form-control" id="Vehiclecapacity" name="Vehiclecapacity" placeholder="Enter Vehicl's Capecity" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <!-- <label for="consignee" class="form-label">Vehicle No.</label>
                                      <input type="text" class="form-control" name="Vehicleno" id="Vehicleno" placeholder="Enter Vehicle No" required> -->

                                      <label for="vehicle">Select Vehicle</label>
            <select name="Vehicleno" id="Vehicleno" class="form-control" required>
                <option value="" disabled selected>Select Vehicle</option>
                
                <?php
                // Fetch vehicles for the dropdown
$vehicles_query = $conn->query("SELECT id, vehicle_type, vehicle_no FROM vehicles ORDER BY vehicle_type ASC");

                while ($vehicle = $vehicles_query->fetch_assoc()): ?>
                    <option value="<?php echo $vehicle['id']; ?>"><?php echo htmlspecialchars($vehicle['vehicle_type']) . ' - ' . htmlspecialchars($vehicle['vehicle_no']); ?></option>
                <?php endwhile; ?>
            </select>
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label for="deliveryAddress" class="form-label">Driver Name</label>
                                  <textarea class="form-control" name="DriverName" id="DriverName" rows="2" placeholder="Enter Driver Name" required></textarea>
                              </div>
                          </div>
                          
                          
                          <!-- Items Section -->
                          <div class="section-card text-bg-light p-2">
                              <h5 class="section-heading">Add Items</h5>
                              <div class="row align-items-end">
                                  <div class="col-md-3 mb-3">
                                      <input type="text" class="form-control" id="itemName" placeholder="Item Name">
                                  </div>
                                  <div class="col-md-3 mb-3">
                                  <select class="form-control" id="parceltype">
                                  <option value="Box">Box</option>
                                  <option value="Bag">Bag</option>
                                  <option value="Basta">Basta</option>
                                  <option value="Bundle">Bundle</option>
                                  <option value="Carton">Carton</option>
                                  <option value="Dozen">Dozen</option>
                                  <option value="Drums">Drums</option>
                                  <option value="Loose">Loose</option>
                                  <option value="Packet">Packet</option>
                                  <option value="Pcs">Pcs</option>
                                  <option value="Roll">Roll</option>
                                    </select>

                                  </div>
                                  
                                  <div class="col-md-2 mb-3">
                                      <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                                  </div>
                                  <div class="col-md-2 mb-3">
                                      <input type="number" class="form-control" id="weight" placeholder="Weight (kg)">
                                  </div>
                                  <div class="col-md-2 mb-3">
                                  <select name="gst" id="itemtax"class="form-control">
                                        <option value="12% GST">12% GST</option>
                                        <option value="5% GST">5% GST</option>
                                        <option value="12% GST">12% GST</option>
                                        <option value="18% GST">18% GST</option>
                                        <option value="28% GST">28% GST</option>
                                        <option value="Tax Free">Tax Free</option>
                                        <option value="28 + 3 CESS">28 + 3 CESS</option>
                                        <option value="IGST 12%">IGST 12%</option>
                                    </select>

                                  </div>
                                  <div class="col-md-2 mb-3">
                                      <input type="number" class="form-control" id="rate" placeholder="Rate">
                                  </div>
                                  <div class="col-md-3 mb-3">
                               <button class="btn btn-secondary" onclick="addItem()"><span class="btn-label">
                               <i class="fa fa-plus"></i>
                               </span>
                        Add Item
                               </button>

                                  </div>
                              </div>
                              <h5 class="section-heading mt-4">Items List</h5>
                              <table class="table table-striped" id="itemsTable">
                                  <thead>
                                  <tr>
                                      <th>Item Name</th>
                                      <th>Parcel Type</th>
                                      <th>Quantity</th>
                                      <th>Weight</th>
                                      <th>Item Tax</th>
                                      <th>Rate</th>
                                      <th>Amount</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                          </div>
                      
                          <!-- Charges Section -->
                          <div class="section-card text-bg-light p-3">
                              <h5 class="section-heading">Add Charges</h5>
                              <div class="row align-items-end">
                                  <div class="col-md-8 mb-3">
                                      <input type="text" class="form-control" id="chargeName" placeholder="Charge Name">
                                  </div>
                                  <div class="col-md-3 mb-3">
                                      <input type="number" class="form-control" id="chargeAmount" placeholder="Amount">
                                  </div>
                                  <div>
                                      <!-- <button type="button" class="btn btn-success w-100" onclick="addCharge()">Add Charge</button> -->
                                      <button class="btn btn-secondary w-100" onclick="addCharge()"><span class="btn-label">
                               <i class="fa fa-plus"></i>
                               </span>
                        Add Charge
                               </button>
                                  </div>
                              </div>
                              <h5 class="section-heading mt-4">Charges List</h5>
                              <table class="table table-striped" id="chargesTable">
                                  <thead>
                                  <tr>
                                      <th>Charge Name</th>
                                      <th>Amount</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                          </div>
                         
                       <!-- Total Charges Section -->
                       
                       
                      </div>
                      </div>
                  <div class="card-action">
                    <button id="alert_demo_3_3" class="btn btn-success" onclick="submitData()">Submit</button>
                    <button class="btn btn-danger">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <!-- <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.themekita.com">
                    ThemeKita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul> -->
            </nav>
            <div class="copyright">
              2024, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://www.themekita.com">SecurX</a>
            </div>
             <div>
              Distributed by
              <a target="_blank">SecurX</a>.
            </div>
          </div>
        </footer>
      </div>

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Google Maps Plugin -->
    <script src="../assets/js/plugin/gmaps/gmaps.js"></script>

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo2.js"></script>
    <script>
let itemList = [];
      let chargesList = [];
  
       // Add an item to the list
       function addItem() {
          const itemName = document.getElementById('itemName').value;
          const parceltype = document.getElementById('parceltype').value;
          const quantity = document.getElementById('quantity').value;
          const weight = document.getElementById('weight').value;
          const itemtax = document.getElementById('itemtax').value;
          const rate = document.getElementById('rate').value;
  
          if (itemName && quantity && weight && rate) {
              const amount = (quantity * rate).toFixed(2);
              itemList.push({ itemName, parceltype, quantity, weight, itemtax, rate, amount });
              updateItemsTable();
              updateTotalCharges();
          } else {
              alert("Please fill all fields for items.");
          }
  
          // Clear inputs
          document.getElementById('itemName').value = '';
          document.getElementById('parceltype').value = '';
          document.getElementById('quantity').value = '';
          document.getElementById('weight').value = '';
          document.getElementById('itemtax').value = '';
          document.getElementById('rate').value = '';
      }
  
      // Update the items table
      function updateItemsTable() {
          const tableBody = document.getElementById('itemsTable').getElementsByTagName('tbody')[0];
          tableBody.innerHTML = ''; // Clear existing rows
  
          itemList.forEach((item, index) => {
              const row = tableBody.insertRow();
              row.innerHTML = `
                  <td>${item.itemName}</td>
                  <td>${item.parceltype}</td>
                  <td>${item.quantity}</td>
                  <td>${item.weight}</td>
                  <td>${item.itemtax}</td>
                  <td>${item.rate}</td>
                  <td>${item.amount}</td>
                  <td><button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Remove</button></td>
              `;
          });
      }
  
      // Remove an item
      function removeItem(index) {
          itemList.splice(index, 1);
          updateItemsTable();
          updateTotalCharges();
      }
  
      // Add a charge to the list
      function addCharge() {
          const chargeName = document.getElementById('chargeName').value;
          const chargeAmount = document.getElementById('chargeAmount').value;
  
          if (chargeName && chargeAmount) {
              chargesList.push({ chargeName, chargeAmount: parseFloat(chargeAmount).toFixed(2) });
              updateChargesTable();
              updateTotalCharges();
          } else {
              alert("Please fill all fields for charges.");
          }
  
          // Clear inputs
          document.getElementById('chargeName').value = '';
          document.getElementById('chargeAmount').value = '';
      }
  
      // Update the charges table
      function updateChargesTable() {
          const tableBody = document.getElementById('chargesTable').getElementsByTagName('tbody')[0];
          tableBody.innerHTML = ''; // Clear existing rows
  
          chargesList.forEach((charge, index) => {
              const row = tableBody.insertRow();
              row.innerHTML = `
                  <td>${charge.chargeName}</td>
                  <td>${charge.chargeAmount}</td>
                  <td><button class="btn btn-danger btn-sm" onclick="removeCharge(${index})">Remove</button></td>
              `;
          });
      }
  
      // Remove a charge
      function removeCharge(index) {
          chargesList.splice(index, 1);
          updateChargesTable();
          updateTotalCharges();
      }
  
      
      function updateTotalCharges() {
              const totalItemCharges = itemList.reduce((sum, item) => sum + parseFloat(item.amount), 0).toFixed(2);
              const totalAdditionalCharges = chargesList.reduce((sum, charge) => sum + parseFloat(charge.chargeAmount), 0).toFixed(2);
              const totalBill = (parseFloat(totalItemCharges) + parseFloat(totalAdditionalCharges)).toFixed(2);
  
              document.getElementById('totalItemCharges').textContent = `${totalItemCharges}`;
              document.getElementById('totalAdditionalCharges').textContent = `${totalAdditionalCharges}`;
              document.getElementById('totalBill').textContent = `${totalBill}`;
          }
  
      function submitData() {
          const consignor = document.getElementById('consignor').value;
          const consignee = document.getElementById('consignee').value;
          const bookingDate = document.getElementById('bookingDate').value;
          const fromLocation = document.getElementById('fromLocation').value;
          const toLocation = document.getElementById('toLocation').value;
          const transportMode = document.getElementById('transportMode').value;
          const paidBy = document.getElementById('paidBy').value;
          const taxPaidBy = document.getElementById('taxPaidBy').value;
          const pickupAddress = document.getElementById('pickupAddress').value;
          const deliveryAddress = document.getElementById('deliveryAddress').value;
          
          const vehicletype = document.getElementById('vehicletype').value;
          const Vehiclecapacity = document.getElementById('Vehiclecapacity').value;
          const Vehicleno = document.getElementById('Vehicleno').value;
          const DriverName = document.getElementById('DriverName').value;
  
          if (!consignor || !consignee || !bookingDate) {
              alert("Please fill all order details.");
              return;
          }
  
          if (itemList.length === 0 && chargesList.length === 0) {
              alert("No items or charges to submit.");
              return;
          }
  
          const data = {
              consignor,
              consignee,
              bookingDate,
              fromLocation,
              toLocation,
              transportMode,
              paidBy,
              taxPaidBy,
              pickupAddress,
              deliveryAddress,
              vehicletype,
              Vehiclecapacity,
              Vehicleno,
              DriverName,
              items: itemList,
              charges: chargesList
          };
  
          fetch('index.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
          })
          .then(response => response.json())
          .then(data =>{            
              // alert(data.message);
              if (data.success) {
                  itemList = [];
                  chargesList = [];
                  updateItemsTable();
                  updateChargesTable();

                  /////////////////to show pop up after successfully submit
                  swal("Booking Done!", "You can get it on booking list!", {
              icon: "success",
              buttons: {
                confirm: {
                  className: "btn btn-success",
                },
              },
            });
            

              }
              
          })
          .catch(error => {
              console.error("Error:", error);
              alert("Submission failed.");
          });
      }
   
      

      
  </script>
  </body>
</html>
