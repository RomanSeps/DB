USE `products` ;

SELECT product.name FROM product LEFT JOIN vendor
ON vendor.id = product.vendor_id;