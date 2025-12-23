<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Display the upload form.
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'products/productsIndexView.php');
    }

    /**
     * Process file upload and save to DB.
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
        $uploadedFiles = $request->getUploadedFiles();

        if (empty($uploadedFiles['productimage'])) {
            FlashMessage::error('No file uploaded.');
            return $this->redirect($request, $response, 'products.index');
        }

        $uploadedFile = $uploadedFiles['productimage'];

        $config = [
            'directory' => APP_UPLOAD_DIR,
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'maxSize' => 2 * 1024 * 1024, 
            'filenamePrefix' => 'upload_'
        ];

        $result = FileUploadHelper::upload($uploadedFile, $config);

        if ($result->isSuccess()) {
            $filename = $result->getData()['filename'];
            $productId = (int) $request->getParsedBody()['product_id'] ?? 0;

            if ($productId <= 0) {
                FlashMessage::error('Invalid product selected.');
                return $this->redirect($request, $response, 'products.index');
            }

            $stmt = $this->db->prepare("
                INSERT INTO product_images (product_id, image_file_path, is_primary)
                VALUES (:product_id, :image_file_path, :is_primary)
            ");
            $stmt->execute([
                ':product_id' => $productId,
                ':image_file_path' => '/uploads/' . $filename,
                ':is_primary' => 0 
            ]);

            FlashMessage::success("Image uploaded successfully: {$filename}");
        } else {
            FlashMessage::error($result->getMessage());
        }

        return $this->redirect($request, $response, 'products.index');
    }
}
