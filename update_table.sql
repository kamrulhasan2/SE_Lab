ALTER TABLE `list`
ADD COLUMN `date_posted` DATE NOT NULL,
ADD COLUMN `time_posted` TIME NOT NULL,
ADD COLUMN `date_edited` DATE NULL,
ADD COLUMN `time_edited` TIME NULL;