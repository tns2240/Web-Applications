
-- Database: `online_job_portal`
--

-- --------------------------------------------------------

-- Table structure for table `jobs`
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255),
    type VARCHAR(255),
    location VARCHAR(255),
    description TEXT,
    requirements TEXT,
    salary VARCHAR(255)
);
-- --------------------------------------------------------


COMMIT;