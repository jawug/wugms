<?php

class record_timesheet_entry {

    /**
     *
     * @var type integer object
     */
    private $timesheet_entry_id;

    /**
     * 
     * @return integer Get ID of entry
     */
    function getTimeSheetEntryID() {
        return $this->timesheet_entry_id;
    }

    /**
     * 
     * @param integer Set ID of entry
     */
    function setTimeSheetEntryID($value) {
        $this->timesheet_entry_id = $value;
    }

    /**
     *
     * @var type datetime object
     */
    private $entry_date;

    /**
     * 
     * @return datetime Get Date for Entry
     */
    function getTimeSheetEntryDate() {
        return $this->entry_date;
    }

    /**
     * 
     * @param datetime Set Date for Entry
     */
    function setTimeSheetEntryDate($value) {
        $this->entry_date = $value;
    }

    /**
     *
     * @var type datetime object
     */
    private $entry_date_system;

    /**
     * 
     * @return datetime Get System Date of Entry
     */
    function getTimeSheetEntryDateSystem() {
        return $this->entry_date_system;
    }

    /**
     * 
     * @param datetime Set System Date of Entry
     */
    function setTimeSheetEntryDateSystem($value) {
        $this->entry_date_system = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $entry_type_foreign_key;

    /**
     * 
     * @return integer Get Entry Type ID
     */
    function getTimeSheetEntryTypeID() {
        return $this->entry_type_foreign_key;
    }

    /**
     * 
     * @param integer Set Entry Type ID
     */
    function setTimeSheetEntryTypeID($value) {
        $this->entry_type_foreign_key = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $entry_type_ref_id;

    /**
     * 
     * @return integer Get Entry Type Ref ID
     */
    function getTimeSheetEntryTypeRefID() {
        return $this->entry_type_ref_id;
    }

    /**
     * 
     * @param integer Set Entry Type Ref ID
     */
    function setTimeSheetEntryTypeRefID($value) {
        $this->entry_type_ref_id = $value;
    }

    /**
     *
     * @var type datetime object
     */
    private $gdate;

    /**
     * 
     * @return datetime Get Group Date
     */
    function getTimeSheetGDate() {
        return $this->gdate;
    }

    /**
     * 
     * @param datetime Set Group Date
     */
    function setTimeSheetGDate($value) {
        $this->gdate = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $time_used;

    /**
     * 
     * @return integer Get Times used
     */
    function getTimeSheetTimeUsed() {
        return $this->time_used;
    }

    /**
     * 
     * @param integer Set Times used
     */
    function setTimeSheetTimeUsed($value) {
        $this->time_used = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $user_foreign_key;

    /**
     * 
     * @return integer Get User ID
     */
    function getTimeSheetUserID() {
        return $this->user_foreign_key;
    }

    /**
     * 
     * @param integer Set User ID
     */
    function setTimeSheetUserID($value) {
        $this->user_foreign_key = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $timesheet_time_multiplier_foreign_key;

    /**
     * 
     * @return integer Get Time Multiplier ID
     */
    function getTimeSheetTimeMultiplierID() {
        return $this->timesheet_time_multiplier_foreign_key;
    }

    /**
     * 
     * @param integer Set Time Multiplier ID
     */
    function setTimeSheetTimeMultiplierID($value) {
        $this->timesheet_time_multiplier_foreign_key = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $timesheet_group_foreign_key;

    /**
     * 
     * @return integer Get Group ID
     */
    function getTimeSheetGroupID() {
        return $this->timesheet_group_foreign_key;
    }

    /**
     * 
     * @param integer Set Group ID
     */
    function setTimeSheetGroupID($value) {
        $this->timesheet_group_foreign_key = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $time_used_calc;

    /**
     * 
     * @return integer Get Time used Calculated
     */
    function getTimeSheetTimeUsedCalc() {
        return $this->time_used_calc;
    }

    /**
     * 
     * @param integer Set Time used Calculated
     */
    function setTimeSheetTimeUsedCalc($value) {
        $this->time_used_calc = $value;
    }

    /**
     *
     * @var type string object
     */
    private $entry_comment;

    /**
     * 
     * @return string Get Entry Comment
     */
    function getTimeSheetEntryComment() {
        return $this->entry_comment;
    }

    /**
     * 
     * @param string Set Entry Comment
     */
    function setTimeSheetEntryComment($value) {
        $this->entry_comment = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $entry_status;

    /**
     * 
     * @return integer Get Entry Status
     */
    function getTimeSheetEntryStatus() {
        return $this->entry_status;
    }

    /**
     * 
     * @param integer Set Entry Status
     */
    function setTimeSheetEntryStatus($value) {
        $this->entry_status = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $entry_type_name;

    /**
     * 
     * @return integer Get Entry Type Name
     */
    function getTimeSheetEntryTypeName() {
        return $this->entry_type_name;
    }

    /**
     * 
     * @param integer Set Entry Type Name
     */
    function setTimeSheetEntryTypeName($value) {
        $this->entry_type_name = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $entry_type_ref_name;

    /**
     * 
     * @return integer Get Entry Type Ref Name
     */
    function getTimeSheetEntryTypeRefName() {
        return $this->entry_type_ref_name;
    }

    /**
     * 
     * @param integer Set Entry Type Ref Name
     */
    function setTimeSheetEntryTypeRefName($value) {
        $this->entry_type_ref_name = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $user_name;

    /**
     * 
     * @return integer Get User Name
     */
    function getTimeSheetUserName() {
        return $this->user_name;
    }

    /**
     * 
     * @param integer Set User Name
     */
    function setTimeSheetUserName($value) {
        $this->user_name = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $timesheet_time_multiplier_name;

    /**
     * 
     * @return integer Get Time Multiplier Name
     */
    function getTimeSheetTimeMultiplierName() {
        return $this->timesheet_time_multiplier_name;
    }

    /**
     * 
     * @param integer Set Time Multiplier Name
     */
    function setTimeSheetTimeMultiplierName($value) {
        $this->timesheet_time_multiplier_name = $value;
    }

    /**
     *
     * @var type integer object
     */
    private $timesheet_group_name;

    /**
     * 
     * @return integer Get Group Name
     */
    function getTimeSheetGroupName() {
        return $this->timesheet_group_name;
    }

    /**
     * 
     * @param integer Set Group Name
     */
    function setTimeSheetGroupName($value) {
        $this->timesheet_group_name = $value;
    }

}

class entity_timesheet {

    /**
     *
     * @var array This contains the items normally used for branding 
     */
    private $branding;

    /**
     *
     * @var \record_timesheet_entry Record of time sheet entry
     */
    private $timesheet_data;

    /**
     *
     * @var type Database object
     */
    private $cdb;

    public function __construct() {
        /* Create a new instance */
        $this->branding = new bwcfwDecoratorPattern();
        $this->timesheet_data = new record_timesheet_entry();
    }

    /**
     * This function inits the DB so that other functions can access the database and perform actions.
     * @return \StatusVO Lots of status
     */
    function init_db() {
        $database_settings = new DBVO();
        $init_db_status = new StatusVO();

        try {
            $this->cdb = new PDO("mysql:host={$database_settings->getHost()};dbname={$database_settings->getDataBase()};charset={$database_settings->getCharset()}", $database_settings->getUserName(), $database_settings->getPassword(), $database_settings->getDataBaseOptions());
        } catch (PDOException $ex) {
            $init_db_status->status = false;
            $init_db_status->status_code = $ex->getMessage();
        }
        if ($init_db_status->status) {
            $this->cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $init_db_status;
    }

    function setTimeSheetNewDBRecord() {
        $timesheet_new_entry_db_write_status = new StatusVO();
        if ($this->init_db()) {
            /* SQL - Query */
            $timesheet_new_entry_db_write_query = "INSERT INTO tbl_base_timesheet_entries(entry_date, sys_entry_date, fk_entry_type, entry_type_ref_id, gdate, time_used, fk_user, fk_timesheet_time_multiplier, fk_timesheet_group, time_used_calc, entry_comment, entry_status) VALUES (:entry_date, :sys_entry_date, :fk_entry_type, :entry_type_ref_id, :gdate, :time_used, :fk_user, :fk_timesheet_time_multiplier, :fk_timesheet_group, :time_used_calc, :entry_comment, :entry_status);";
            /* SQL - Params */
            $timesheet_new_entry_db_write_params = array(
                ':entry_date' => $this->entry_date,
                ':sys_entry_date' => $this->sys_entry_date,
                ':fk_entry_type' => $this->fk_entry_type,
                ':entry_type_ref_id' => $this->entry_type_ref_id,
                ':gdate' => $this->gdate,
                ':time_used' => $this->time_used,
                ':fk_user' => $this->fk_user,
                ':fk_timesheet_time_multiplier' => $this->fk_timesheet_time_multiplier,
                ':fk_timesheet_group' => $this->fk_timesheet_group,
                ':time_used_calc' => $this->time_used_calc,
                ':entry_comment' => $this->entry_comment,
                ':entry_status' => 1
            );
            /* SQL - Exec */
            try {
                $timesheet_new_entry_db_write_stmt = $this->cdb->prepare($timesheet_new_entry_db_write_query);
                $timesheet_new_entry_db_write_status->status = $timesheet_new_entry_db_write_stmt->execute($timesheet_new_entry_db_write_params);
            } catch (PDOException $ex) {
                /* SQL - Error(s) */
                $leave_email_addresses_status->status = false;
                $leave_email_addresses_status->status_code = $ex->getMessage();
            }
        } else {
            $timesheet_new_entry_db_write_status->status_code = $this->init_db()->status_code;
            $timesheet_new_entry_db_write_status->status = false;
        }
        return $timesheet_new_entry_db_write_status;
    }

    function getTimeSheetDBRecord($id) {
        $timesheet_get_entry_db_read_status = new StatusVO();
        if ($this->init_db()) {
            /* SQL - Query */
            $timesheet_get_entry_db_read_query = "SELECT id_timesheet_entry, entry_date, sys_entry_date, fk_entry_type, entry_type_ref_id, gdate, time_used, fk_user, fk_timesheet_time_multiplier, fk_timesheet_group, time_used_calc, entry_comment, entry_status FROM tbl_base_timesheet_entries WHERE id_timesheet_entry = :id_timesheet_entry;";
            /* SQL - Params */
            $timesheet_get_entry_db_read_params = array(
                ':id_timesheet_entry' => $id
            );
            /* SQL - Exec */
            try {
                $timesheet_get_entry_db_read_stmt = $this->cdb->prepare($timesheet_get_entry_db_read_query);
                $timesheet_get_entry_db_read_status->status = $timesheet_get_entry_db_read_stmt->execute($timesheet_get_entry_db_read_params);
            } catch (PDOException $ex) {
                /* SQL - Error(s) */
                $timesheet_get_entry_db_read_status->status = false;
                $timesheet_get_entry_db_read_status->status_code = $ex->getMessage();
            }

            if ($timesheet_get_entry_db_read_status->status) {
                $timesheet_get_entry_db_read_row = $timesheet_get_entry_db_read_stmt->fetch();
                if ($timesheet_get_entry_db_read_row) {
                    foreach ($leave_email_addresses_row as $key => $value) {
                        $this->timesheet_data->setTimeSheetEntryComment($timesheet_get_entry_db_read_row['email_address']);
                    }
                } else {
                    $timesheet_get_entry_db_read_status->status = false;
                    $timesheet_get_entry_db_read_status->status_code = 'No data.';
                }
            }
        } else {
            $timesheet_get_entry_db_read_status->status_code = $this->init_db()->status_code;
            $timesheet_get_entry_db_read_status->status = false;
        }
        return $timesheet_get_entry_db_read_status;
    }

}
