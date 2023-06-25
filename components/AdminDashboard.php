<?php

if (Authentication::isAdmin()) {
    $dashboards = [
        // ['link' => '#', 'title' => 'Users', 'color' => 'green_color', 'total' => DashboardController::totalUsers()],
        // ['link' => '#', 'title' => 'Customers', 'color' => 'blue_color', 'total' => DashboardController::totalCustomers()],
        ['link' => './transporters.php', 'title' => 'Transporters', 'color' => 'red_color', 'total' => DashboardController::totalTransporters()],
        // ['link' => '#', 'title' => 'Orders', 'color' => 'yellow_color', 'total' => DashboardController::totalOrders()],
        // ['link' => '#', 'title' => 'Payments', 'color' => 'red_color', 'total' => DashboardController::totalPayments()],
        ['link' => './companies.php', 'title' => 'Transport Companies', 'color' => 'blue_color', 'total' => DashboardController::totalTransportCompanies()],
    ];
}

if (Authentication::isTransporter()) {
    $dashboards = [
        ['link' => './vehicles.php', 'title' => 'Vehicles', 'color' => 'green_color', 'total' => TransporterController::countVehicles()],
    ];
}

if (Authentication::isManager()) {
    $dashboards = [
        ['link' => './products.php', 'title' => 'Products', 'color' => 'yellow_color', 'total' => ManagerController::totalProducts()],
        ['link' => './pending-orders.php', 'title' => 'Pending Orders', 'color' => 'green_color', 'total' => ManagerController::totalOrders('NOT PAID')],
        ['link' => './verified-orders.php', 'title' => 'Verified Orders', 'color' => 'red_color', 'total' => ManagerController::totalOrders('PAID')],
    ];
}

if (Authentication::isCustomer()) {
    $dashboards = [
        ['link' => './customer-orders.php', 'title' => 'My Orders', 'color' => 'green_color', 'total' => CustomerController::totalOrders()],
    ];
}


foreach ($dashboards as $dashboard) {
    echo '            
            <a href="' . $dashboard['link'] . '" class="single_quick_activity  d-flex">
                <div class="count_content count_content2">
                    <h3>
                        <span class="counter ' . $dashboard['color'] . '">' . $dashboard['total'] . '</span>
                    </h3>
                    <p>' . $dashboard['title'] . '</p>
                </div>
            </a>
        ';
}
