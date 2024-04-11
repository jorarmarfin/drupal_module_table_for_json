<?php

namespace Drupal\table_for_json\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TableForJsonController extends ControllerBase {

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function content(Request $request): JsonResponse
    {
        // Obtener el nombre de la tabla desde la configuración del módulo
        $config = $this->config('table_for_json.settings');
        $table_name = $config->get('table_name');
        // Leer el parámetro 'page' de la URL, y usar 0 como valor predeterminado si no se especifica
        $page = $request->query->get('page', 0);
        $items_per_page = $config->get('paginate_for');
        $authorizationHeader = $request->headers->get('Authorization');
        if ($config->get('basic_auth') && $this->basicAuthCheck($request) === FALSE) {
            $response = new Response();
            $response->headers->set('WWW-Authenticate', sprintf('Basic realm="%s"', 'Restricted area'));
            $response->setStatusCode(401, 'Authentication Required');
            return new JsonResponse(['error' => 'Acceso no autorizado.'], 401);
        }

        // Verificar si la tabla existe para prevenir inyecciones SQL
        $schema = Database::getConnection()->schema();
        if (!$schema->tableExists($table_name)) {
            throw new BadRequestHttpException("La tabla especificada no existe.");
        }

        // Obteniendo la conexión a la base de datos
        $connection = Database::getConnection();
        $query = $connection->select($table_name, 't')
            ->fields('t'); // Aplicar paginación

        $query = ($page=='all')?$query:$query->range($page * $items_per_page, $items_per_page); // Aplicar paginación

        $result = $query->execute()->fetchAll();

        // Preparar los datos para la respuesta JSON
        $data = [];
        foreach ($result as $row) {
            $data[] = (array) $row;
        }

        return new JsonResponse($data);
    }
    private function basicAuthCheck(Request $request): bool
    {
        $username = $request->headers->get('PHP_AUTH_USER');
        $password = $request->headers->get('PHP_AUTH_PW');
        if (!$username || !$password) {
            return FALSE;
        }

        $users = Drupal::entityTypeManager()->getStorage('user')
            ->loadByProperties(['name' => $username, 'status' => 1]);

        $user = reset($users);

        if ($user && Drupal::service('password')->check($password, $user->getPassword())) {
            return TRUE;
        }

        return FALSE;
    }

}
