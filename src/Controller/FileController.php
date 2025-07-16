<?php
namespace App\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController extends AbstractController
{
    #[Route('/files', name: 'file_index')]
    public function index(FileRepository $fileRepository): Response
    {
        $files = $fileRepository->findAll();
        return $this->render('file/index.html.twig', [
            'files' => $files,
            'baseUrl' => $this->getParameter('app.base_url') ?? '',
        ]);
    }

    #[Route('/files/upload', name: 'file_upload')]
    public function upload(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->files->get('file');
            if ($uploadedFile) {
                $originalName = $uploadedFile->getClientOriginalName();
                $type = $uploadedFile->getClientMimeType();
                $fileName = uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);

                $file = new File();
                $file->setName($originalName);
                $file->setType($type);
                $file->setPath('/uploads/'.$fileName);
                
                $file->setSharedLink(bin2hex(random_bytes(16)));
                $em->persist($file);
                $em->flush();

                return $this->redirectToRoute('file_index');
            }
        }
        return $this->render('file/upload.html.twig');
    }
    #[Route('/files/share/{sharedLink}', name: 'file_share')]
    public function share(FileRepository $fileRepository, string $sharedLink): Response
    {
        $file = $fileRepository->findOneBy(['sharedLink' => $sharedLink]);
        if (!$file) {
            throw $this->createNotFoundException('Fichier non trouvé.');
        }
        $filePath = $this->getParameter('kernel.project_dir').'/public'.$file->getPath();
        return $this->file($filePath, $file->getName());
    }

    #[Route('/files/download/{id}', name: 'file_download')]
    public function download(File $file): Response
    {
        $filePath = $this->getParameter('kernel.project_dir').'/public'.$file->getPath();
        return $this->file($filePath, $file->getName());
    }

    #[Route('/files/delete/{id}', name: 'file_delete')]
    public function delete(File $file, EntityManagerInterface $em): Response
    {
        $em->remove($file);
        $em->flush();
        return $this->redirectToRoute('file_index');
    }
}
