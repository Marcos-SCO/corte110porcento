<?php

namespace App\Traits;

trait ProductsImages
{
  
  public function moveUploadImageFolder($data)
  {
    $id = $data['id'];
    $productIdCategory = $data['product_id_category'];

    $currentProductCategoryId = $data['current_product_category_id'];

    $currentAndSelectedCategoriesAreEqual =
      $currentProductCategoryId == $productIdCategory;

    $result = $this->model->getProduct($id, $productIdCategory);

    $resultId = $this->model->getProductId($id);

    $imgFiles = indexParamExistsOrDefault($data, 'img_files');
    $imgName = indexParamExistsOrDefault($imgFiles, 'name');
    $tempName = indexParamExistsOrDefault($imgFiles, 'tmp_name');

    $postImg = $data['post_img'];

    if (!$result) {

      $isEmptyImg = $imgName == "";

      if ($isEmptyImg) $data['img_name'] = $postImg;

      if (!$isEmptyImg) {

        $createdFolderPath =
          $this->imagesHandler->createCategoryItemFolder('products', $id, $productIdCategory);

        $this->imagesHandler->moveUpload($createdFolderPath);

        $data['img_name'] = $imgName;

        return $data;
      }
    }

    // Create a new path
    $fullPath = $this->imagesHandler->createCategoryItemFolder('products', $productIdCategory, $id) . $imgName;

    $this->imagesHandler->moveUpload($fullPath);

    // Get img data
    $img = ($imgName !== '') ? $imgName : $postImg;

    // Copy from the older to new one
    $oldFolderPath = "../public/resources/img/products/category_{$resultId->id_category}/id_$id/$img";

    $newFolderPath = "../public/resources/img/products/category_{$productIdCategory}/id_$id/$img";

    if (file_exists($oldFolderPath)) {

      copy($oldFolderPath, $newFolderPath);

      // Delete old folder
      if (!$currentAndSelectedCategoriesAreEqual) $this->imagesHandler->deleteFolder('products', $id, $resultId->id_category);
    }

    $data['img_name'] = $img;

    return $data;
  }
}
