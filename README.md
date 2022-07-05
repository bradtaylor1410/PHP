# PHP
Code snippets from lotto project. On a weekly basis a cron was set to create a new lotto for the next draw. Also a cron was required to find winners from the list of lotto tickets

#SMS Breif

To send SMS just call the function prepareSMS(), include the mobile number(s), productid, providerid and message

All SMS’s are recorded in a table to track the history. This can also be used for billing purposes. All entries are time stamped to allow for  future analysis.

SMS Function can be tweaked to accomodate multiple providers once the formating has been established for each provider. Function is flexible enough to select different providers, and send from multiple products.

Version 2 would be to measure traffic spikes when SMS is sent, particulaly when sent from multiple products.

CREATE TABLE `smsLog` (
  `id` bigint(20) NOT NULL,
  `smsId` varchar(12) NOT NULL,
  `providerId` int(2) NOT NULL COMMENT 'each new provider would be given a unique ID',
  `productId` mediumint(9) NOT NULL,
  `mobile` int(10) NOT NULL,
  `messageStatus` int(11) NOT NULL COMMENT '0 fail, 1 success',
  `sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `smsLog`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `smsLog`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
