<?php
return [

	'dialog' => [
		'title' => [
			//basic
			'add' => 'Add :name ',
			'edit' => 'Edit :name ',
			'delete' => 'Delete :name ',
			'view' => 'View :name ',
			'copy' => 'Copy :name ',
			'delete_info' => 'This operation will delete',
			'delete_continue' => ' , continue?',
			'delete_tag_continue' => 'Test cases, do you want to continue?',

			//projectLib
			'notification' => 'Notification',
			'copy_project_notification' => 'The project is in progress, please wait for 30s and it will be refreshed automatically!',
			'success' => 'Success',
			'copy_project_success' => 'The project was copied successfully!',
			'uncopy' => 'Cancel Copy',
			'unedit' => 'Cancel Edit',

			//testCase
			'tag_management' => 'Tag Management',
			'select_or_create_run' => 'Select or create a new run list',
			'add_run_list' => 'Add a run list',
			'select_tag' => 'Please select a label (multiple choices, up to ten)',
			'association' => ' Association ',
			'testcase_error_message' => 'Please select test cases that need to be added in batches!',
			'delete_warnning' => 'Delete Warnning',
			'delete_wrong_message_1' => 'The test case ',
			'delete_wrong_message_2' => ' cannot be deleted, it is already referenced by another test case?',

			//instruction
			'insert_bundle' => 'Insert Instruction Bundle',
			'instruction_bundle' => 'Instruction Bundle',
			'insert_bundle_set' => 'Insert Instruction Bundle Setting',
			'reference_testcase' => 'Reference TestCase',
			'edit_reference_testcase' => 'Edit Reference TestCase',
			'add_instruction' => 'Add Instruction',
			'add_comment_instruction' => 'Add Comment Instruction',
			'add_rpc_dubbo_instruction' => 'Add Rpc(Dubbo) Instruction',
            'add_check_email_instruction' => 'Add Check Email Instruction',
            'edit_check_email_instruction' => 'Edit Check Email Instruction',
			'add_processor_instruction' => 'Add Processor Instruction',
			'add_validator_instruction' => 'Add Validator Instruction',
			'add_api_instruction' => 'Add API Instruction',
			'add_webbrowser_action' => 'Add webBrowser Action',
			'add_stringUtil_instruction' => 'Add StringUtil Instruction',
			'add_sql_statement' => 'Add SQL Statement',
			'add_js_script' => 'Add JavaScript',
			'edit_instruction' => 'Add Instruction',
			'edit_comment_instruction' => 'Edit Comment Instruction',
			'edit_validator_instruction' => 'Edit Validator Instruction',
			'edit_api_instruction' => 'Edit API Instruction',
			'edit_webbrowser_action' => 'Edit webBrowser Action',
			'edit_sql_statement' => 'Edit SQL Statement',
			'edit_js_script' => 'Edit JavaScript',
			'edit_rpc_dubbo_instruction' => 'Edit Dubbo Instruction',
			'application' => 'Application',
			'section' => 'Section',
			'element' => 'Elemeent',
			'folder' => 'Folder',
			'target_testcase' => 'Target TestCase',
			'testcase_overwrite' => 'TestCase Overwrite',
			'sql_statement' => 'SQL Statement',
			'js_script' => 'JavaScript',
			'webrowser_action' => 'WebBrowser Action',
			'rpc_dubbo' => 'Ins Name',
			'rpc_dubbo_port' => 'Dubbo port',
			'rpc_dubbo_zk_host' => 'zk host',
			'rpc_dubbo_zk_port' => 'zk port',
			'rpc_dubbo_qos_port' => 'Qos port',
			'rpc_dubbo_interface_name' => 'Interface',
			'rpc_dubbo_interface_method' => 'Method',
			'rpc_dubbo_parameters' => 'Parameter',
            'check_email_subject' => 'Subject',
            'check_email_subject_check_type' => 'Subject CheckType',
            'check_email_content' => 'Content',
            'check_email_content_check_type' => 'Content CheckType',
            'check_email_sender' => 'Sender Nickname',
            'check_email_address' => 'Sender Address',
            'check_email_time_span' => 'Send Time In',
			'expression' => 'Expression',
			'summary_comment' => 'Summary/Comment',
			'step' => 'Step',
			'expected' => 'Expected',
			'drive_dep' => 'Drive Dependence',
			'drive_need' => 'The type of driver required to run the test case ',
			'set_cluster' => 'Set up the test execution cluster',
			'execution_cluster' => 'Execution Cluster',
			'overwrite_name' => 'OverWrite Name',
			'drive_pack' => 'Drive Package',
			'debug' => 'Debug',
			'prod' => 'Product',
			'run_fail' => 'Running Failed',
			'fail_message' => 'Run failed, no data is available to run',
			'debug_start' => 'Start debugging',
			'debug_message' => 'Start debugging, Can jump to the running status page to view the status!',
			'prod_start' => 'Start of operation',
			'prod_message' => 'Start of operation, Can jump to the running status page to view the status!',
			'operation_error' => 'Operation error',
			'error_message' => 'This use case has been referenced more than ten times and cannot be used to create new references in this use case.',
			'error_message_run_list' => 'The run list has been referenced and a new reference cannot be created in the list!',
			'edit_error_message' => "Edit not completed, can't save!",
			'show_error_message' => 'The operation is incorrect. If more than one line is selected, the next step cannot be added.',
			'data_error_message' => "The data is incorrect and the operation cannot be performed!",
			'null_error_message' => "The operation is incorrect, the data is not selected, and the next step cannot be added.",
			'only_error_message' => 'The operation is wrong, only one line can be selected!',
			'add_error' => 'Add an error!',
			'select_error_message' => 'Please select the application and section first!',
			'file_type' => 'FileType',
			'file_path' => 'FilePath',
			'driver' => 'Driver',
			'check_result' => 'CheckResult',
			'save_result' => 'SaveResult',
			'stringUtil_action' => 'StringUtil Instruction',

			//folder
			'select_all_error_message' => 'Operation error, you are not allowed to select all at once here, please select the test cases you want to add in turn!',

			'insert_location' => 'Add test step insertion location',
			'insert_position' => 'Insert Position',
			'insert_under' => 'Insert Under',
			'insert_on' => 'Insert On',

			'copy_testcase_overwrite' => 'Copy test case parameter configuration',
			'reference_testcase_overwrite' => 'Reference test case parameter settings',
			'edit_instructin_overwrite_message_1' => 'This operation will affect ',
			'edit_instructin_overwrite_message_2' => ' InstructionOverwrite in the parameter configuration under the test case. Do you want to continue?',
			'delete_instruction_overwrite' => 'Delete InstructionOverwrite',
			'delete_info_1' => 'This will delete the InstructionOverwrite, continue?',
			'delete_testcase_overwrite' => 'Delete TestCaseOverwrite',
			'delete_info_2' => 'This will delete the TestCaseOverwrite, continue?',

			//move
			'step_move' => 'Test step move',
			'direction' => 'Direction',
			'move_up' => 'Move up',
			'move_down' => 'Move Downward',
			'move_steps' => 'Moving steps',

			//api
			'select' => 'Select',
			'api_name' => 'API Name',
			'api_save_as' => 'Save the API as',
			'pre_run' => 'Pre-run',
			'save_not' => 'Save JsonPath results',
			'status_code' => 'Status Code',
			'debug_result' => 'Debug Result',
			'api_element_warning_message_1' => 'This action will affect the ',
			'api_element_warning_message_2' => ' InstructionOverwrites that reference the interface element. Do you want to continue?',

			//apiElement
			'save_or_not_change' => 'Whether to save this change?',
			'save_or_not_change_message' => 'All the instructions containing this element after saving will be affected！',
			'unchange' => 'Cancel edit',

			//apiInstruction
			'cancel_change' => 'Whether to abandon this modification?',
			'cancel_change_message' => 'All operations that give up this page will not be saved!',

			//element
			'add_element' => 'Add Element',
			'position_attribute' => 'Position Attribute',
			'attribute_value' => 'Attribute Value',
			'project' => 'Project',
			'un_delete_element' => 'The delete element ',
			'not_available' => ' is not available and there is  ',
			'containing_message' => ' test case with this element.',
			'containing_message_2' => 'The following test cases containing this element or use cases that reference test cases containing this element will be affected.',
			'edit_element_message_1' => 'This action will affect the ',
			'edit_element_message_2' => ' Instructions that reference the element. Do you want to continue?',

			//runlist
			'project_lib' => 'ProjectLib',
			'test_case' => 'TestCase',
			'list_name' => 'ListName',
			'select_alias' => 'Select Alias',
			'alias_management' => 'Alias Management',
			'refrence_list' => 'Reference Run List',
			'set_run_list' => 'List Run Notification Settings',
			'add_notification' => 'Add Notification',
			'notification_list' => 'Notification List',
			'see_detail' => 'See Details',
			'notification_manage' => 'Notification Management',
			'set_notification' => 'Run Notification Settings',
			'recipient_manage' => 'Recipient Management',
			'set_recipient' => 'Recipient Setting',
			'recipient' => 'Recipient',
			'add_recipient' => 'Add Recipient',
			'theme' => 'Theme',
			'email' => 'Email',
			'once_alarm' => 'Once Alarm',
			'cycling_alarm' => 'Cycling Alarm',
			'set_testcase_overwrite' => 'Set TestCase Overwrite',
			'set_testcase_driver' => 'Set TestCase Driver',
			'lack_driver_pack' => 'Driver package not configured',

			'delete_referen_list_from_list' => 'This action will remove the run list reference ',
			'delete_testcase_from_list' => 'This action will remove the test case ',
			'delete_from_list_continue' => ' from the list. Do you want to continue?',

			//alarm
			'set_once_success' => 'Single alarm setting is successful',
			'set_once_message' => 'The single execution of the alarm is set successfully and will be executed automatically at the specified time!',
			'set_cycling_success' => 'Cycle alarm set successfully',
			'set_ocycling_message' => 'The cycle alarm is set successfully and will be executed automatically at the specified time!',
			'please_select_notification' => 'Please select the notification you want to add before adding',
			'delete_list_notification' => 'Delete list notification',
			'delete_notification_from_list' => 'This action will remove the notification from the run list ',
			'delete_notification' => 'Delete notification',
			'delete_notification_message' => 'This action will delete the notification ',
			'delete_recipient' => 'Delete recipient',
			'delete_recipient_message' => 'This action will delete the recipient ',
			'cancel_once_success' => 'Single alarm canceled successfully',
			'cancel_once_message' => 'A single execution of the alarm is cancelled successfully! ',
			'cancel_cycling_success' => 'The loop alarm is cancelled successfully.',
			'cancel_ocycling_message' => 'The loop execution alarm is cancelled successfully! ',

			//modulePro
			'class_name' => 'ClassName',
			'user_name' => 'UserName',
			'password' => 'Password',

			'property_name' => 'Property Name',
			'defaults' => 'Defaults',
			'description' => 'Description',
			'value_type' => 'Value Type',
			'value' => 'Value',
			'delete_driver_message_1' => 'The delete engine ',
			'delete_driver_message_2' => ' is not available and the engine package ',
			'delete_driver_message_3' => ' containing the engine will be affected.',

			//runResult
			'testcase_stop_success' => 'Test case Run Stop Successful!',
			'run_log' => 'Run Logs',
			'log_info' => 'Log Info',
			'detail' => 'Details',
			'view_screenshot' => 'View Screenshot',
			'project_area_chart' => 'Project run result area chart',
			'run_result' => 'Run result',
			'project_change' => 'Project success and error changes',
			'total_number_testcase' => 'Total number of test cases',
			'running_total' => 'Total amount of operation',
			'project_establishment_time' => 'Project establishment time',
			'testcase_run_time' => 'Test case run time',
			'found_problem' => 'Found a problem',
			'problem_fix' => 'Problem fixing',
			'navigator_testcase' => 'Go to see all test cases',
			'navigator_testcase_result' => 'Go to view test case run results',
			'run_number' => 'Number of runs',

			'view_report_details' => 'View list report details',
			'code_info' => 'Code information',
			'expected_value' => 'Expected value',
			'actual_value' => 'Actual value',
			'test_instruction' => 'Test explanation',
			'timeout' => 'Timeout',
			'no_problem' => 'No problems found',
			'screenshot' => 'Screenshot',

			'prompt' => 'Prompt',
			'no_error_testcase' => 'There are no error use cases under this use case!',
			'rerun_completed' => 'Re-run operation completed',
			'rerun_start' => 'The rerun test case has started, please return to view and wait for the result!',
			'view_api' => 'View API',

		],

		'placeholder' => [
			//basic
			'enter_id' => 'Please enter id',
			'enter_name' => 'Please enter a name',
			'enter_comment' => 'Please enter a comment',
			'select_date' => 'Please select a date and time',

			//instructionBundle
			'select_instruction_type' => 'Please select the type of instruction',
			'select_element_type' => 'Please select an element type',
			'select_action' => 'Please select an action',

			//projectLib
			'select_project_type' => 'Please select the item type',

			//testCase
			'select_tag' => 'Please select tags, up to four',
			'select_type' => 'Please select type, no need to select if use default',
			'select_run_plan' => 'Please select the operation plan',

			//instruction
			'select' => 'Please select(can search)',
			'enter' => 'Please enter',
			'enter_email' => 'Please enter the email address. Please separate the multiple email addresses with ";". Do not enter ";" at the end.',

			//runlist
			'select_alias' => 'Select Alias',

		],
	],

	'table' => [
		//basic
		'id' => 'Id',
		'name' => 'Name',
		'create_at' => 'CreateAt',
		'update_at' => 'UpdateAt',
		'comment' => 'Comment',
		'operating' => 'Operating',
		'start_date' => 'StartDate',
		'end_date' => 'EndDate',

		//instructionBUndleEntry
		'instruction_type' => 'Instruction Type',
		'element_type' => 'Element Type',
		'instruction_action' => 'Instruction Action',

		//projectLib
		'project_type' => 'ProjectType',

		//testCase
		'tag' => 'Tag',
		'mark' => 'Mark',
		'project' => 'Project',

		//insruction
		'target' => 'Target',
		'action' => 'Action',
		'input' => 'Input',
		'option' => 'Option',
		'type' => 'Type',
		'string_check' => 'StringDataProcessor',
		'math_check' => 'MathExpressionProcessor',
		'string_util' => 'String Util',

		//runlist
		'priority' => 'Priority',
		'testcase_name' => 'TestCase Name',
		'overwrite_name' => 'Overwrite Name',
		'driver_name' => 'Driver Name',
		'testcase_comment' => 'TestCase Comment',
		'reference_message' => 'A run list is referenced here',
		'testcase_number' => 'TestCase Number',
		'alias' => 'Alias',

		//modulePro
		'engine_name' => 'DriverName',
		'vendor' => 'Vendor',
		'version' => 'Version',
		'default' => 'Default',

		//runStatus
		'run_status' => 'Run Status',
		'progress' => 'Progress',
		'has_executed' => 'executed',
		'operating_environment' => 'Operating Environment',

		//runResult
		'testcase_quantity' => 'TestCase Quantity',
		'total_executed' => 'Total Executed',
		'run_date' => 'Run Date',
		'success_total_last' => 'success/Total(last)',
		'success_total' => 'success/Total',
		'error' => 'Error',
		'number_of_run' => 'Number Of Runs',
		'not_run' => 'Not Running',
		'overwrite' => 'OverWrite',
		'trigger_source' => 'Trigger Source',
		'status' => 'Status',
		'driver' => 'Driver',
		'pass_rate' => 'Passing rate',

	],

	'operator' => [
		//basic
		'new' => 'New',
		'edit' => 'Edit',
		'delete' => 'Delete',
		'export' => 'Export',
		'view' => 'View',
		'copy' => 'Copy',
		'setting' => 'Setting',
		'searching' => 'Searching',
		'reset' => 'Reset',
		'undelete' => 'Undelete',
		'confirm' => 'Confirm',
		'cancel' => 'Cancel',
		'new_guider' => 'Beginner\'s Guide',

		//folder
		'add_to_testcase' => 'Add To TestCase',
		'go_to_testcase' => 'Go to TestCase view',
		'stay_folder_testcase' => 'Stay in the Folder TestCase',

		//projectLib
		'open' => 'Open',
		'test_case' => 'Test Case',
		'api_management' => 'API Management',
		'soap_management' => 'SOAP Management',
		'element_management' => 'Element Management',

		//testCase
		'tag' => 'Tag',
		'select_tag' => 'Select Tag',
		'tag_management' => 'Tag Management',
		'add_to_run' => 'Add to run list',
		'and' => 'AND',
		'or' => 'OR',
		'go_to_run' => 'Go to run and set view',
		'stay_test_case' => 'Stay in the use case library',

		//instruction
		'color_label' => 'Color label',
		'move' => 'Move',
		'overwrite' => 'Overwrite',
		'web_function' => 'WebFunction',
		'virtual_web_function' => 'VirutalWebFunction',
		'performance' => 'Performance',
		'manual' => 'Manual',
		'reference' => 'Reference',
		'reference_message' => 'Test cases are referenced here',
		'rest_api' => 'API',
		'rpc_dubbo' => 'DubboService',
		'web_browser' => 'WebBrowser',
		'virtual_web_browser' => 'VirtualWebBrowser',
		'sql' => 'SQL',
		'javascript' => 'JavaScript',
		'processor' => 'Processor',
		'comment' => 'Comment',
		'run' => 'Run',
		'instruction_bundle_insert' => 'Insert Bundle',
		'view_drive' => 'View Drive',
		'edit_done' => 'Edit Done',
		'folder_reference' => 'Folder Reference',
		'redis' => 'Redis',
		'string_util' => 'String Util',
        'email' => 'CheckEmail',

		//runlist
		'set_drive' => 'Set Driver',
		'set_overwrite' => 'New Overwrite',
		'notification_setting' => 'Notification',
		'add_to_notification_list' => 'AddToNotificationList',
		'select_alias' => 'Select Alias',
		'alias_management' => 'Alias Management',

		//runResult
		'run_result' => 'RunResult',
		'debug_result' => 'DebugResult',
		'project_overview' => 'ProjectOverView',
		'summary_result' => 'SummaryResult',
		'error_testcase' => 'ErrorTestCase',
		'view_report' => 'ViewReport',
		'terminate_operation' => 'TerminateOperation',
		'error_testcase_callback' => 'rerun',
		'view_task' => 'View Task',

	],

	'validator' => [
		'name' => [
			'required' => 'Cannot be empty (select or enter)',
			'exist' => 'The name database already exists, please change',
			'consists' => 'The name consists of a numeric character with a length of 1-32 and an underlined Chinese character',
		],
		'project_type' => 'Project Type is required',
		'url' => 'Please enter a valid full URL, such as "http://baidu.com"',
		'email' => 'The mailbox format is incorrect. Please separate the multiple email addresses with ";". Do not enter ";" at the end.',
	],

	'breadcrumb' => [
		//instructionBundle
		'instruction_bundle' => 'Instruction Bundle',
		'bundle_entry' => 'Instruction Bundle Entry',

		//folder
		'folder' => 'Folder',
		'folder_list' => 'Folder List',

		//projectLib
		'project_lib' => 'ProjectLib',
		'project_list' => 'Project List',
		'test_case' => 'Test Case',
		'api_management' => 'API Management',
		'soap_management' => 'SOAP Management',
		'element_management' => 'Element Management',

		//instruction
		'instruction' => 'Instruction',

		//apielement
		'api_element' => 'ApiElementManagement',

		//application
		'application' => 'Application',
		'section' => 'Section',
		'element' => 'Entry Element',
		'test_case_lib' => 'TestCaseLib',
		'test_case_list' => 'TestCase List',

		//runlist
		'run_list' => 'RunSet/RunList',
		'list_detail' => 'List Details',

		//modulePro
		'engine' => 'Engine settings',
		'engine_property' => 'Engine Property',
		'engine_package' => 'Engine Package Management',
		'system_requirements_packs' => 'System Requirements Package',
		'packs_system_requirements' => 'System Requirements',

		//runStatus
		'project_status' => 'Project Status',
		'testcase_status' => 'TestCase Status',
		'run_list_status' => 'Run List Status',
		'list_detail' => 'Run List Details',

		//runResult
		'project_result' => 'ProjectResult',
		'result_detail' => 'ResultDetails',
		'case_result' => 'TestCaseResult',
		'step_result' => 'InstructionResult',
		'list_result' => 'RunListResult',
		'testcase_result' => 'TestCaseRunResult',
		'project_global_result' => 'ProjectGlobalResult',
		'api_detail' => 'ApiDetails',

		'system_set' => 'System Setting',
	],

];
