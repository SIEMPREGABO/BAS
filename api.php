<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'db_connection.php';
require_once 'clients.php';
require_once 'services.php';
require_once 'appointments.php';
require_once 'memberships.php';
require_once 'payments.php';
require_once 'notifications.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', $uri);

$endpoint = $uriSegments[count($uriSegments)-1];
$resource = isset($uriSegments[count($uriSegments)-2]) ? $uriSegments[count($uriSegments)-2] : null;

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Initialize classes
$client = new Client();
$service = new Service();
$appointment = new Appointment();
$membership = new Membership();
$payment = new Payment();
$notification = new Notification();

// Handle requests
switch ($requestMethod) {
    case 'GET':
        if ($resource === 'clients') {
            if ($endpoint === 'clients') {
                // Get all clients
                $response = $client->getClients();
            } elseif (is_numeric($endpoint)) {
                // Get single client
                $response = $client->getClient($endpoint);
            }
        } elseif ($resource === 'services') {
            if ($endpoint === 'services') {
                // Get all services
                $category = isset($_GET['category']) ? $_GET['category'] : null;
                $response = $service->getServices($category);
            } elseif (is_numeric($endpoint)) {
                // Get single service
                $response = $service->getService($endpoint);
            }
        } elseif ($resource === 'appointments') {
            if ($endpoint === 'appointments') {
                // Get appointments with filters
                $filters = array();
                if (isset($_GET['start_date'])) $filters['start_date'] = $_GET['start_date'];
                if (isset($_GET['end_date'])) $filters['end_date'] = $_GET['end_date'];
                if (isset($_GET['status'])) $filters['status'] = $_GET['status'];
                if (isset($_GET['client_id'])) $filters['client_id'] = $_GET['client_id'];
                
                $response = $appointment->getAppointments($filters);
            } elseif (is_numeric($endpoint)) {
                // Get single appointment
                $response = $appointment->getAppointment($endpoint);
            } elseif ($endpoint === 'availability') {
                // Check availability
                if (isset($_GET['start_datetime']) && isset($_GET['duration'])) {
                    $response = array(
                        'available' => $appointment->checkAvailability($_GET['start_datetime'], $_GET['duration'])
                    );
                } else {
                    http_response_code(400);
                    $response = array('error' => 'Missing parameters');
                }
            }
        } elseif ($resource === 'memberships') {
            if ($endpoint === 'memberships') {
                // Get all memberships
                $response = $membership->getMemberships();
            } elseif ($endpoint === 'client' && isset($_GET['client_id'])) {
                // Get client memberships
                $response = $membership->getClientMemberships($_GET['client_id']);
            }
        }
        break;
        
    case 'POST':
        if ($resource === 'clients') {
            // Create new client
            $response = $client->createClient($input);
        } elseif ($resource === 'appointments') {
            // Create new appointment
            $response = $appointment->createAppointment($input);
        } elseif ($resource === 'memberships' && $endpoint === 'assign') {
            // Assign membership to client
            if (isset($input['client_id']) && isset($input['membership_id'])) {
                $response = $membership->assignMembershipToClient($input['client_id'], $input['membership_id']);
            } else {
                http_response_code(400);
                $response = array('error' => 'Missing parameters');
            }
        }
        break;
        
    case 'PUT':
        if ($resource === 'appointments' && is_numeric($endpoint)) {
            // Update appointment status
            if (isset($input['status'])) {
                $response = $appointment->updateAppointmentStatus($endpoint, $input['status']);
            } else {
                http_response_code(400);
                $response = array('error' => 'Missing status parameter');
            }
        }
        break;
        
    default:
        http_response_code(405);
        $response = array('error' => 'Method not allowed');
        break;
}

echo json_encode($response);
?>