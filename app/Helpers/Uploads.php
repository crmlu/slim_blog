<?php

declare(strict_types=1);

namespace App\Helpers;

use Slim\Http\Request;
use Psr\Container\ContainerInterface;
use Slim\Http\UploadedFile;
use App\Models\UploadsModel;

class Uploads
{
    protected ContainerInterface $dc;
    protected UploadsModel $data;
    protected string $upload_dir;
    protected array $allowed_types;
    protected string $prefix;

    public function __construct(ContainerInterface $container, string $upload_dir) {
        $this->dc = $container;
        $this->upload_dir = $upload_dir;
        $this->allowed_types = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png'
        ];
        $this->prefix = date('Y/m/d');
        $this->data = $container->get('Uploads');
    }

    protected function save(UploadedFile $candidate): ?int
    {
        $upload_dir = $this->upload_dir . DIRECTORY_SEPARATOR . $this->prefix;
        if ($candidate->getError() === UPLOAD_ERR_OK) {
            $mime = $candidate->getClientMediaType();
            if (array_key_exists($mime, $this->allowed_types)) {
                $extension = $this->allowed_types[$mime];
                $basename = bin2hex(random_bytes(8));
                $filename = sprintf('%s.%s_up', time() . $basename, $extension);
                
                if (!is_dir($upload_dir) && !mkdir($upload_dir, 0775, true)) {
                    //todo
                    throw new \Exception('Could not create upload directory');
                }
                $candidate->moveTo($upload_dir . DIRECTORY_SEPARATOR . $filename);
                $db_data = [
                    'name' => $candidate->getClientFilename(),
                    'location' => $this->prefix . DIRECTORY_SEPARATOR . $filename,
                    'size' => filesize($upload_dir . DIRECTORY_SEPARATOR . $filename),
                ];
                return $this->data->insert($db_data);
            } else {
                //todo
                throw new \Exception('Unsupported file type uploaded');
            }
        } else {
            //todo error reporting!
            return null;
        }
    }

    public function create(UploadedFile $candidate): ?int
    {
        return $this->save($candidate);
    }

    public function update(UploadedFile $candidate, ?string $id): ?int
    {
        $result = $this->save($candidate);
        if (!empty($result)) {
            $this->data->delete((int)$id);
            return $result;
        } else {
            return $id;
        }
    }

    public function getMimeTypeByExt(string $ext): string
    {
        switch (strtolower($ext)) {
            case "png":
                $type = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $type = "image/jpeg";
                break;
            default:
                $type = "application/binary";
                break;
        }
        return $type;
    }

    public function getDir(): string
    {
        return $this->upload_dir;
    }
}
