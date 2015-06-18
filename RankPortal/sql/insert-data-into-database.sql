-- user demo

INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (1, 'test', '28e123b2d8041c081a9bab3efe9c31d3fb80f1c0');

-- product demo

INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (1, 'Demo', 'Test', '/img/placeholder.png', 1);

-- ratings demo

INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (1, 'Super', 3, 1, 1);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (2, 'Not good', 5, 1, 1);