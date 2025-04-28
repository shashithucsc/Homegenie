<?php
class ProfileSVPModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProfileDetails($service_provider_id)
    {
        $this->db->query('
        SELECT 
            u.user_id,
            CONCAT(u.first_name, " ", u.last_name) as name,
            u.email,
            u.contact_number as phone,
            u.address
        FROM users u
        WHERE u.user_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);

        $row = $this->db->single();
        return $row;
    }


    public function updateProfileFields($data)
    {
        $query = "
        UPDATE service_providers
        SET expertise = :expertise,
            service_areas = :service_areas,
            working_hours = :working_hours
        WHERE provider_id = :service_provider_id
    ";

        $this->db->query($query);
        $this->db->bind(':expertise', $data['expertise']);
        $this->db->bind(':service_areas', $data['service_areas']);
        $this->db->bind(':working_hours', $data['working_hours']);
        $this->db->bind(':service_provider_id', $data['service_provider_id']);

        return $this->db->execute();
    }




    public function getUserDetails($user_id)
    {
        $this->db->query('
        SELECT 
            user_id,
            first_name,
            last_name,
            email,
            contact_number,
            street,
            district,
            province,
            profile_image
        FROM users 
        WHERE user_id = :user_id
    ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function getProviderDetails($provider_id)
    {
        $this->db->query('
        SELECT 
            provider_id,
            expertise,
            description,
            working_hours,
            service_areas,
            id_number,
            hourly_rate
        FROM service_providers 
        WHERE provider_id = :provider_id
    ');
        $this->db->bind(':provider_id', $provider_id);
        return $this->db->single();
    }

    public function getAverageRating($service_provider_id)
    {
        $this->db->query('
        SELECT AVG(rating) as average_rating 
        FROM appointments 
        WHERE service_provider_id = :service_provider_id 
        AND finish_status = "complete" 
        AND rating IS NOT NULL
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $result = $this->db->single();
        return $result ? round($result->average_rating, 1) : 0;
    }

    public function getQuotationStats($service_provider_id)
    {
        $this->db->query('
        SELECT 
            SUM(CASE WHEN status = "Approved" THEN 1 ELSE 0 END) as approved_count,
            SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN status = "Rejected" THEN 1 ELSE 0 END) as rejected_count
        FROM quotations 
        WHERE service_provider_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->single();
    }

    public function getJobStats($service_provider_id)
    {
        $this->db->query('
        SELECT 
            SUM(CASE WHEN finish_status = "complete" THEN 1 ELSE 0 END) as completed_jobs,
            SUM(CASE WHEN finish_status = "pending" THEN 1 ELSE 0 END) as pending_jobs
        FROM appointments 
        WHERE service_provider_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->single();
    }
    public function updateProfessionalInfo($provider_id, $expertise, $working_hours, $service_areas, $description, $hourly_rate)
    {
        $this->db->query('
        UPDATE service_providers 
        SET 
            expertise = :expertise,
            working_hours = :working_hours,
            service_areas = :service_areas,
            description = :description,
            hourly_rate = :hourly_rate
        WHERE provider_id = :provider_id
    ');

        $this->db->bind(':expertise', $expertise);
        $this->db->bind(':working_hours', $working_hours);
        $this->db->bind(':service_areas', $service_areas);
        $this->db->bind(':description', $description);
        $this->db->bind(':hourly_rate', $hourly_rate);
        $this->db->bind(':provider_id', $provider_id);

        return $this->db->execute();
    }

    public function updateWorkPhotos($service_provider_id, $work_photos)
    {
        $upload_dir = dirname(dirname(dirname(__DIR__))) . '/public/img/SVPpic/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Get existing photos
        $this->db->query('SELECT work_photos FROM service_providers WHERE provider_id = :provider_id');
        $this->db->bind(':provider_id', $service_provider_id);
        $result = $this->db->single();
        $existing_photos = $result ? explode(',', $result->work_photos) : [];

        $new_photos = [];
        foreach ($work_photos['tmp_name'] as $key => $tmp_name) {
            if ($work_photos['error'][$key] === UPLOAD_ERR_OK) {
                $new_photos = [];
                foreach ($work_photos['tmp_name'] as $key => $tmp_name) {
                    if ($work_photos['error'][$key] === UPLOAD_ERR_OK) {
                        $original_name = basename($work_photos['name'][$key]);
                        $unique_name = uniqid() . '_' . $original_name;  // ADD this
                        $target_path = $upload_dir . $unique_name;        // UPDATE this

                        if (move_uploaded_file($tmp_name, $target_path)) {
                            $new_photos[] = $unique_name;                // UPDATE this
                        }
                    }
                }
            }
        }

        $all_photos = array_merge($existing_photos, $new_photos);
        $photos_string = implode(',', array_filter($all_photos));

        // Update in database
        $this->db->query('
        UPDATE service_providers 
        SET work_photos = :work_photos 
        WHERE provider_id = :provider_id
    ');
        $this->db->bind(':work_photos', $photos_string);
        $this->db->bind(':provider_id', $service_provider_id);

        return $this->db->execute();
    }

    public function deleteWorkPhoto($service_provider_id, $photo_index)
    {
        $upload_dir = dirname(dirname(dirname(__DIR__))) . '/public/img/SVPpic/';

        $this->db->query('SELECT work_photos FROM service_providers WHERE provider_id = :provider_id');
        $this->db->bind(':provider_id', $service_provider_id);
        $result = $this->db->single();

        if ($result && $result->work_photos) {
            $photos = explode(',', $result->work_photos);

            if (isset($photos[$photo_index])) {
                $photo_to_delete = $photos[$photo_index];
                $file_path = $upload_dir . $photo_to_delete;

                unset($photos[$photo_index]);
                $photos = array_values($photos); // Reindex

                $this->db->query('
                UPDATE service_providers 
                SET work_photos = :work_photos 
                WHERE provider_id = :provider_id
            ');
                $this->db->bind(':work_photos', implode(',', $photos));
                $this->db->bind(':provider_id', $service_provider_id);

                if ($this->db->execute()) {
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    return ['success' => true];
                } else {
                    return ['success' => false, 'error' => 'Failed to update photo information'];
                }
            } else {
                return ['success' => false, 'error' => 'Photo not found'];
            }
        } else {
            return ['success' => false, 'error' => 'No photos found'];
        }
    }
}
