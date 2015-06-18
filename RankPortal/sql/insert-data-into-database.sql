-- user demo

INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (1, 'test', '28e123b2d8041c081a9bab3efe9c31d3fb80f1c0');
INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (2, 'test2', '6b3aed0e158ba5fe7f843068ce3de3dd66903471');
INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (3, 'test3', 'fcc101db77c430938c51314a4249421b1a28b1ad');
INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (4, 'test4', '10c3662941b2275933c2d7a042adc61a96e4eb56');
INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
  (5, 'test5', 'b351bfc1e4922d5bfc392e9953ad6260448dadc0');

-- product demo

INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (1, 'Playstation 4', 'Sony', 'http://store.sony.com/SNYNA_27/pimg/pSNYNA-PS490005_main_v786.png', 1);
INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (2, 'Xbox One', 'Microsoft', 'http://compass.xbox.com/assets/94/60/946002c9-dfc7-44fe-b20a-abf175c49d42.jpg?n=og-share-meet-xbox-one-955x955.jpg', 1);
INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (3, 'MacBook Air', 'Apple', 'http://www1.pcmag.com/media/images/427049-apple-macbook-air-13-inch-2014-open.jpg?thumb=y', 2);
INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (4, 'Galaxy S6', 'Samsung', 'http://cnet3.cbsistatic.com/hub/i/r/2015/02/26/3ce5a1c6-25ca-41e6-8707-fa26a0e9a594/thumbnail/770x433/00e6566ddead8d8f0e33130b84bbba20/batllo-0853.jpg', 3);
INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (5, 'Demo', 'Test', 'img/placeholder.png', 1);
INSERT INTO `products` (`id`, `productName`, `vendor`, `imagePath`, `userId`) VALUES
  (6, 'Demo', 'Test', '/img/placeholder.png', 1);

-- ratings demo

INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (1, 'Ok', 3, 1, 1);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (2, 'Super nice', 1, 1, 2);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (3, '', 5, 1, 3);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (4, '', 5, 1, 4);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (5, 'BS', 5, 2, 1);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (6, 'Best thing ever happend! :)', 1, 3, 5);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (7, 'Not good', 2, 2, 5);
INSERT INTO `ratings` (`id`, `comment`, `rank`, `productId`, `userId`) VALUES
  (8, 'Not good', 1, 2, 4);