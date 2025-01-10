<?php
require_once 'controllers/chamadosController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$controller = new ChamadosController();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', trim($uri, '/'));

if (isset($uriSegments[1]) && $uriSegments[1] === 'chamados') {
    switch ($method) {
        case 'GET': 
            if (isset($uriSegments[2])) {
                $id = (int) $uriSegments[2];
                $controller->listarChamadoPorId($id); 
            } else {
                $controller->listarChamados(); 
            }
            break;

        case 'POST': 
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['titulo'], $data['descricao'])) {
                $controller->criarChamado($data['titulo'], $data['descricao']);
            } else {
                echo json_encode(['message' => 'Dados inválidos']);
            }
            break;

        case 'PUT': 
            if (isset($uriSegments[2])) {
                $id = (int) $uriSegments[2];
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['titulo'], $data['descricao'], $data['status'])) {
                    $controller->atualizarChamado($id, $data['titulo'], $data['descricao'], $data['status']);
                } else {
                    echo json_encode(['message' => 'Dados inválidos']);
                }
            } else {
                echo json_encode(['message' => 'ID do chamado não fornecido']);
            }
            break;

        case 'DELETE': 
            if (isset($uriSegments[2])) {
                $id = (int) $uriSegments[2];
                $controller->excluirChamado($id);
            } else {
                echo json_encode(['message' => 'ID do chamado não fornecido']);
            }
            break;

        default:
            echo json_encode(['message' => 'Método HTTP não suportado']);
            break;
    }
} else {
    echo json_encode(['message' => 'Endpoint inválido']);
}
?>
