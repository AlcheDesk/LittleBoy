<?php
return [
    'type' => [
        'en' => [
            'ATM' => [
                // instructionBundle
                'instruction_bundle' => 'Instruction Bundle',
                'bundle_entry' => 'Instruction Bundle Entry',

                // folder
                'folder' => 'Folder',
                'folder_test_case' => 'Test Case',

                // projectLib
                'project_lib' => 'ProjectLib',
                'test_case' => 'Test Case',
                'test_case_tag' => 'Test Case Tag',
                'instruction' => 'Instruction',
                'api_instruction' => 'ApiInstruction',

                'system_set' => 'System Setting',

                // apielement
                'api_element' => 'Api Element',
                'api_element_edit' => 'ApiELement',
                // application
                'application' => 'Application',
                'section' => 'Section',
                'element' => 'Element',

                // runlist
                'run_list' => 'RunList',
                'run_list_tag' => 'RunList Tag',
                'run_list_test_case' => 'Test Case',

                // modulePro
                'engine' => 'Engine',
                'engine_property' => 'Engine Property',
                'engine_package' => 'Engine Package',
                'system_requirements_packs' => 'System Requirements Package',
                'packs_system_requirements' => 'System Requirements'
            ],
            'RBAC' => [
                'system_permission' => 'System Permission',
                'group' => 'Group',
                'user' => 'User',
                'group_user' => 'Group User',
                'group_permission' => 'Group Permission'
            ]
        ],

        'zh-CN' => [
            'ATM' => [
                // instructionBundle
                'instruction_bundle' => '指令包',
                'bundle_entry' => '模板步骤',

                // folder
                'folder' => '收藏夹',
                'folder_test_case' => '测试用例',

                // projectLib
                'project_lib' => '项目库',
                'test_case' => '测试用例',
                'test_case_tag' => '测试用例标签',
                'instruction' => '用例步骤',
                'api_instruction' => '用例接口步骤',

                'system_set' => '设置',

                // apielement
                'api_element' => '接口元素',
                'api_element_edit' => '接口元素',

                // application
                'application' => '项目板块',
                'section' => '项目子版块',
                'element' => '元素',

                // runlist
                'run_list' => '自定义执行列表',
                'run_list_tag' => '自定义执行列表标签',
                'run_list_test_case' => '测试用例',

                // modulePro
                'engine' => '引擎',
                'engine_property' => '引擎属性',
                'engine_package' => '引擎包',
                'system_requirements_packs' => '系统需求包',
                'packs_system_requirements' => '系统需求'
            ],
            'RBAC' => [
                'system_permission' => '系统权限',
                'group' => '群组',
                'user' => '用户',
                'group_user' => '群组用户',
                'group_permission' => '群组权限'
            ]
        ]
    ],
    'info' => [
        'ATM' => [
            // basic info
            'basic' => [
                'table' => [
                    'id',
                    'name',
                    'comment',
                    'create_at',
                    'update_at',
                    'operating',
                    'start_date',
                    'end_date'
                ],
                'dialog' => [
                    'title' => [
                        'add',
                        'edit',
                        'delete',
                        'delete_info',
                        'delete_continue',
                        'copy'
                    ],
                    'placeholder' => [
                        'enter_name',
                        'enter_comment',
                        'enter_id',
                        'select_date'
                    ]
                ],
                'validator' => [
                    'name'
                ],
                'operator' => [
                    'new',
                    'edit',
                    'delete',
                    'confirm',
                    'cancel',
                    'searching',
                    'reset',
                    'undelete'
                ]
            ],

            // Instruction Bundle
            'instruction_bundle' => [
                'breadcrumb' => [
                    'instruction_bundle'
                ]
            ],

            // bundle_entry
            'bundle_entry' => [
                'breadcrumb' => [
                    'instruction_bundle',
                    'bundle_entry'
                ],
                'table' => [
                    'instruction_type',
                    'comment',
                    'element_type',
                    'instruction_action'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select_instruction_type',
                        'select_element_type',
                        'select_action'
                    ]
                ]
            ],

            // folder
            'folder' => [
                'breadcrumb' => [
                    'folder',
                    'folder_list'
                ]
            ],

            'folder_test_case' => [
                'breadcrumb' => [
                    'folder',
                    'test_case'
                ],
                'table' => [
                    'project'
                ],
                'dialog' => [
                    'title' => [
                        'project_lib',
                        'test_case',
                        'operation_error',
                        'testcase_error_message',
                        'select_all_error_message',
                        'error_message'
                    ]
                ],
                'operator' => [
                    'stay_folder_testcase',
                    'go_to_testcase',
                    'add_to_testcase',
                    'open'
                ]
            ],

            // ProjectLib
            'project_lib' => [
                'breadcrumb' => [
                    'project_lib',
                    'project_list',
                    'test_case',
                    'api_management',
                    'element_management',
                    'soap_management'
                ],
                'table' => [
                    'project_type'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select_project_type'
                    ],
                    'title' => [
                        'view',
                        'copy',
                        'notification',
                        'copy_project_notification',
                        'success',
                        'copy_project_success',
                        'uncopy'
                    ]
                ],
                'operator' => [
                    'setting',
                    'export',
                    'view',
                    'copy',
                    'open'
                ]
            ],

            // testcase
            'test_case' => [
                'breadcrumb' => [
                    'project_lib',
                    'test_case',
                    'test_case_lib',
                    'test_case_list'
                ],
                'table' => [
                    'tag',
                    'type',
                    'mark',
                    'project'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select_tag',
                        'select_type',
                        'select_run_plan'
                    ],
                    'title' => [
                        'select_tag',
                        'copy',
                        'tag_management',
                        'select_or_create_run',
                        'add_run_list',
                        'uncopy',
                        'delete_tag_continue',
                        'association',
                        'operation_error',
                        'testcase_error_message',
                        'delete_warnning',
                        'delete_wrong_message_1',
                        'delete_wrong_message_2',
                    ]
                ],
                'operator' => [
                    'add_to_run',
                    'export',
                    'view',
                    'copy',
                    'open',
                    'tag',
                    'select_tag',
                    'tag_management',
                    'and',
                    'or',
                    'go_to_run',
                    'stay_test_case'
                ]
            ],

            // Instruction
            'instruction' => [
                'breadcrumb' => [
                    'project_lib',
                    'test_case',
                    'instruction'
                ],
                'table' => [
                    'tag',
                    'target',
                    'action',
                    'input',
                    'option',
                    'instruction_type',
                    'element_type',
                    'instruction_action',
                    'type',
                    'string_check',
                    'math_check',
                    'testcase_name',
                    'string_util'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select_instruction_type',
                        'select_element_type',
                        'select_action',
                        'select',
                        'enter'
                    ],
                    'title' => [
                        'copy',
                        'uncopy',
                        'insert_bundle',
                        'instruction_bundle',
                        'insert_bundle_set',
                        'reference_testcase',
                        'edit_reference_testcase',
                        'add_instruction',
                        'add_comment_instruction',
                        'add_processor_instruction',
                        'add_rpc_dubbo_instruction',
                        'add_check_email_instruction',
                        'add_api_instruction',
                        'add_webbrowser_action',
                        'add_sql_statement',
                        'add_js_script',
                        'edit_instruction',
                        'edit_comment_instruction',
                        'edit_processor_instruction',
                        'edit_check_email_instruction',
                        'edit_api_instruction',
                        'edit_webbrowser_action',
                        'edit_sql_statement',
                        'edit_js_script',
                        'application',
                        'section',
                        'element',
                        'target_testcase',
                        'sql_statement',
                        'js_script',
                        'webrowser_action',
                        'expression',
                        'summary_comment',
                        'step',
                        'expected',
                        'drive_dep',
                        'drive_need',
                        'set_cluster',
                        'execution_cluster',
                        'overwrite_name',
                        'drive_pack',
                        'debug',
                        'prod',
                        'run_fail',
                        'fail_message',
                        'debug_start',
                        'debug_message',
                        'prod_start',
                        'prod_message',
                        'operation_error',
                        'error_message',
                        'edit_error_message',
                        'insert_location',
                        'insert_position',
                        'insert_under',
                        'insert_on',
                        'add_element',
                        'position_attribute',
                        'attribute_value',
                        'step_move',
                        'direction',
                        'move_up',
                        'move_down',
                        'move_steps',
                        'select',
                        'copy_testcase_overwrite',
                        'reference_testcase_overwrite',
                        'show_error_message',
                        'edit_instructin_overwrite_message_1',
                        'edit_instructin_overwrite_message_2',
                        'unedit',
                        'data_error_message',
                        'null_error_message',
                        'add_error',
                        'only_error_message',
                        'delete_instruction_overwrite',
                        'delete_info_1',
                        'delete_testcase_overwrite',
                        'delete_info_2',
                        'select_error_message',
                        'folder',
                        'testcase_overwrite',
                        'file_type',
                        'file_path',
                        'debug_result',
                        'pre_run',
                        'expected',
                        'save_not',
                        'driver',
                        'check_result',
                        'save_result',
                        'stringUtil_action',
                        'rpc_dubbo',
                        'rpc_dubbo_port',
                        'rpc_dubbo_zk_host',
                        'rpc_dubbo_zk_port',
                        'rpc_dubbo_qos_port',
                        'rpc_dubbo_interface_name',
                        'rpc_dubbo_interface_method',
                        'rpc_dubbo_parameters',
                        'edit_rpc_dubbo_instruction',
                        'check_email_subject',
                        'check_email_subject_check_type',
                        'check_email_content',
                        'check_email_content_check_type',
                        'check_email_sender',
                        'check_email_address',
                        'check_email_time_span',
                    ]
                ],
                'operator' => [
                    'color_label',
                    'move',
                    'overwrite',
                    'web_function',
                    'virtual_web_function',
                    'performance',
                    'manual',
                    'reference',
                    'rest_api',
                    'rpc_dubbo',
                    'email',
                    'web_browser',
                    'virtual_web_browser',
                    'sql',
                    'javascript',
                    'processor',
                    'comment',
                    'run',
                    'instruction_bundle_insert',
                    'view_drive',
                    'copy',
                    'edit_done',
                    'reference_message',
                    'folder_reference',
                    'set_overwrite',
                    'redis',
                    'string_util',
                ]
            ],

            // ApiInstruction
            'api_instruction' => [
                'breadcrumb' => [
                    'project_lib',
                    'test_case',
                    'instruction'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select',
                        'enter'
                    ],
                    'title' => [
                        'api_name',
                        'api_save_as',
                        'pre_run',
                        'save_not',
                        'status_code',
                        'debug_result',
                        'expected',
                        'save_or_not_change',
                        'save_or_not_change_message',
                        'unchange',
                        'cancel_change',
                        'cancel_change_message'
                    ]
                ],
                'validator' => [
                    'url'
                ]
            ],

            // apielement
            'api_element' => [
                'breadcrumb' => [
                    'project_lib',
                    'api_element'
                ],
                'dialog' => [
                    'title' => [
                        'api_name',
                        'api_element_warning_message_1',
                        'api_element_warning_message_2',
                        'unedit'
                    ]
                ],
                'table' => [
                    'element_type',
                    'action'
                ]
            ],

            // apiElementEdit
            'api_element_edit' => [
                'breadcrumb' => [
                    'project_lib',
                    'api_element'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select',
                        'enter'
                    ],
                    'title' => [
                        'api_name',
                        'save_or_not_change',
                        'save_or_not_change_message',
                        'unchange'
                    ]
                ],
                'validator' => [
                    'url'
                ]
            ],

            // application
            'application' => [
                'breadcrumb' => [
                    'application',
                    'project_lib'
                ]
            ],

            'section' => [
                'breadcrumb' => [
                    'application',
                    'project_lib',
                    'section'
                ]
            ],

            'element' => [
                'breadcrumb' => [
                    'application',
                    'project_lib',
                    'section',
                    'element',
                    'test_case'
                ],
                'table' => [
                    'element_type'
                ],
                'dialog' => [
                    'title' => [
                        'position_attribute',
                        'attribute_value',
                        'project',
                        'un_delete_element',
                        'not_available',
                        'containing_message',
                        'containing_message_2',
                        'unedit',
                        'edit_element_message_1',
                        'edit_element_message_2'
                    ]
                ]
            ],

            // runlist
            'run_list' => [
                'breadcrumb' => [
                    'run_list'
                ],
                'table' => [
                    'alias',
                    'priority',
                    'testcase_number'
                ],
                'dialog' => [
                    'placeholder' => [
                        'select_alias'
                    ],
                    'title' => [
                        'select_alias',
                        'alias_management',
                        'delete_tag_continue',
                        'operation_error'
                    ]
                ],
                'operator' => [
                    'select_alias',
                    'alias_management',
                    'and',
                    'or',
                    'export'
                ]
            ],

            'run_list_test_case' => [
                'breadcrumb' => [
                    'run_list',
                    'list_detail'
                ],
                'table' => [
                    'tag',
                    'priority',
                    'testcase_name',
                    'overwrite_name',
                    'driver_name',
                    'testcase_comment',
                    'reference_message',
                    'input',
                    'project'
                ],
                'dialog' => [
                    'placeholder' => [
                        'enter_email'
                    ],
                    'title' => [
                        'operation_error',
                        'project_lib',
                        'test_case',
                        'list_name',
                        'refrence_list',
                        'set_run_list',
                        'add_notification',
                        'notification_list',
                        'see_detail',
                        'notification_manage',
                        'set_notification',
                        'recipient_manage',
                        'set_recipient',
                        'recipient',
                        'theme',
                        'email',
                        'debug',
                        'prod',
                        'execution_cluster',
                        'once_alarm',
                        'cycling_alarm',
                        'set_testcase_overwrite',
                        'set_testcase_driver',
                        'add_recipient',
                        'delete_referen_list_from_list',
                        'delete_testcase_from_list',
                        'delete_from_list_continue',
                        'run_fail',
                        'fail_message',
                        'debug_start',
                        'debug_message',
                        'prod_start',
                        'prod_message',
                        'drive_dep',
                        'drive_need',
                        'error_message_run_list',
                        'unedit',
                        'set_once_success',
                        'set_once_message',
                        'set_cycling_success',
                        'set_ocycling_message',
                        'please_select_notification',
                        'delete_list_notification',
                        'delete_notification_from_list',
                        'delete_notification',
                        'delete_notification_message',
                        'delete_recipient',
                        'delete_recipient_message',
                        'cancel_once_success',
                        'cancel_once_message',
                        'cancel_cycling_success',
                        'cancel_ocycling_message',
                        'copy',
                        'uncopy',
                        'lack_driver_pack'
                    ]
                ],
                'operator' => [
                    'and',
                    'or',
                    'reference',
                    'view_drive',
                    'run',
                    'set_drive',
                    'set_overwrite',
                    'notification_setting',
                    'copy',
                    'add_to_notification_list'
                ],
                'validator' => [
                    'email'
                ]
            ],

            // modulePro
            'engine' => [
                'breadcrumb' => [
                    'engine',
                    'engine_package'
                ],
                'table' => [
                    'engine_name',
                    'vendor',
                    'version',
                    'default',
                    'type'
                ],
                'dialog' => [
                    // 'placeholder' => ['select_tag'],
                    'title' => [
                        'class_name',
                        'user_name',
                        'password',
                        'delete_driver_message_1',
                        'delete_driver_message_2',
                        'delete_driver_message_3'
                    ]
                ],
                'operator' => [
                    'undelete'
                ]
            ],

            'engine_property' => [
                'breadcrumb' => [
                    'engine',
                    'engine_property'
                ],
                'dialog' => [
                    'title' => [
                        'property_name',
                        'defaults',
                        'description',
                        'value_type',
                        'value'
                    ]
                ],
                'operator' => [
                    'undelete'
                ]
            ],

            'engine_package' => [
                'breadcrumb' => [
                    'engine_package'
                ],
                'operator' => [
                    'undelete'
                ]
            ],

            'system_requirements_packs' => [
                'breadcrumb' => [
                    'system_requirements_packs'
                ],
                'dialog' => [
                    'title' => [
                        'value'
                    ]
                ],
                'table' => [
                    'type'
                ],
                'operator' => [
                    'undelete'
                ]
            ],
            'packs_system_requirements' => [
                'breadcrumb' => [
                    'system_requirements_packs',
                    'packs_system_requirements'
                ],
                'dialog' => [
                    'title' => [
                        'value'
                    ]
                ],
                'table' => [
                    'type'
                ],
                'operator' => [
                    'undelete'
                ]
            ],

            // runStatus
            'run_status' => [
                'breadcrumb' => [
                    'project_status',
                    'testcase_status',
                    'run_list_status',
                    'list_detail'
                ],
                'table' => [
                    'run_status',
                    'progress',
                    'operating_environment',
                    'has_executed'
                ],
                'operator' => []
            ],

            // runResult
            'run_result' => [
                'dialog' => [
                    'title' => [
                        'testcase_stop_success',
                        'success',
                        'run_log',
                        'log_info',
                        'detail',
                        'view_screenshot',
                        'project_area_chart',
                        'run_result',
                        'project_change',
                        'total_number_testcase',
                        'running_total',
                        'project_establishment_time',
                        'testcase_run_time',
                        'found_problem',
                        'problem_fix',
                        'navigator_testcase',
                        'navigator_testcase_result',
                        'run_number',
                        'list_name',
                        'step',
                        'expected_value',
                        'actual_value',
                        'view_report_details',
                        'code_info',
                        'test_instruction',
                        'timeout',
                        'no_problem',
                        'screenshot',
                        'prompt',
                        'no_error_testcase',
                        'rerun_completed',
                        'rerun_start',
                        'api_name',
                        'view_api'
                    ]
                ],
                'breadcrumb' => [
                    'project_result',
                    'result_detail',
                    'case_result',
                    'step_result',
                    'list_result',
                    'testcase_result',
                    'project_global_result',
                    'project_global_result',
                    'api_detail'
                ],
                'table' => [
                    'testcase_quantity',
                    'total_executed',
                    'run_date',
                    'success_total_last',
                    'success_total',
                    'error',
                    'option',
                    'number_of_run',
                    'overwrite',
                    'trigger_source',
                    'priority',
                    'status',
                    'driver',
                    'not_run',
                    'operating_environment',
                    'pass_rate',
                    'target',
                    'action',
                    'string_check',
                    'math_check',
                    'testcase_name'
                ],
                'operator' => [
                    'run_result',
                    'debug_result',
                    'project_overview',
                    'summary_result',
                    'error_testcase',
                    'view_report',
                    'terminate_operation',
                    'web_function',
                    'virtual_web_function',
                    'performance',
                    'manual',
                    'reference',
                    'rest_api',
                    'rpc_dubbo',
                    'email',
                    'web_browser',
                    'virtual_web_browser',
                    'sql',
                    'javascript',
                    'processor',
                    'comment',
                    'error_testcase_callback',
                    'view_task',
                    'redis',
                ]
            ],

            // systemSetting
            'system_set' => [
                'breadcrumb' => [
                    'system_set'
                ]
            ]
        ],

        'EMS' => [
            'controll_center' => [
                'table' => [
                    'id',
                    'priority',
                    'work_name',
                    'creator_ip',
                    'update_at',
                    'status',
                    'task'
                ],
                'text' => [
                    'exec_unit_status',
                    'new',
                    'executing',
                    'pass',
                    'fail',
                    'empty',
                    'hang',
                    'off_line'
                ],
                'menu' => [
                    'exec_overview'
                ]
            ],
            'work' => [
                'table' => [
                    'id',
                    'priority',
                    'work_name',
                    'creator_ip',
                    'update_at',
                    'status',
                    'task',
                    'type',
                    'log',
                    'summary',
                    'start_date',
                    'end_date',
                    'search',
                    'time'
                ],
                'menu' => [
                    'work_list'
                ]
            ],
            'task' => [
                'table' => [
                    'id',
                    'priority',
                    'work_id',
                    'name',
                    'start_exec_at',
                    'exec_system',
                    'status',
                    'type',
                    'log',
                    'start_date',
                    'end_date',
                    'search',
                    'time'
                ],
                'menu' => [
                    'testcase_detail'
                ]
            ],
            'execution_unit' => [
                'table' => [
                    'id',
                    'name',
                    'status',
                    'update_at',
                    'group',
                    'current_task',
                    'ip',
                    'port',
                    'mac',
                    'cpu_arch',
                    'cpu_core_number',
                    'memory',
                    'system'
                ],
                'menu' => [
                    'exec_unit'
                ]
            ]
        ],

        'RBAC' => [
            'basic' => [
                'table' => [
                    'id',
                    'comment',
                    'create_at',
                    'operating',
                    'distribution_details',
                    'click_for_detail'
                ],
                'dialog' => [
                    'title' => [
                        'add',
                        'edit',
                        'delete',
                        'delete_info',
                        'delete_continue'
                    ],
                    'label' => [
                        'comment'
                    ],
                    'placeholder' => [
                        'enter_name',
                        'enter_comment'
                    ]
                ],
                'validator' => [
                    'name'
                ],
                'operator' => [
                    'new',
                    'edit',
                    'delete',
                    'confirm',
                    'cancel',
                    'undelete'
                ]
            ],
            'system_permission' => [
                'dialog' => [
                    'title' => [
                        'permission_details',
                        'have_permission',
                        'details_of_permission'
                    ],
                    'label' => [
                        'permission_name',
                        'user',
                        'group'
                    ]
                ],
                'table' => [
                    'permission_name'
                ],
                'breadcrumb' => [
                    'system_auth_manage'
                ]
            ],
            'group' => [
                'dialog' => [
                    'title' => [
                        'group_details',
                        'have_group',
                        'details_of_group',
                        'open'
                    ],
                    'label' => [
                        'group_name',
                        'user',
                        'permission'
                    ]
                ],
                'table' => [
                    'group_name'
                ],
                'breadcrumb' => [
                    'group_manage'
                ],
                'operator' => [
                    'config',
                    'group_user',
                    'group_permission'
                ]
            ],
            'user' => [
                'dialog' => [
                    'title' => [
                        'user_details',
                        'have_user',
                        'details_of_user',
                        'open'
                    ],
                    'label' => [
                        'user_name',
                        'group',
                        'permission',
                        'email',
                        'password'
                    ],
                    'placeholder' => [
                        'enter_email',
                        'enter_password'
                    ]
                ],
                'table' => [
                    'user_name',
                    'email'
                ],
                'breadcrumb' => [
                    'user_manage'
                ],
                'operator' => [
                    'config',
                    'record',
                    'pass',
                    'refuse',
                ],
                'validator' => [
                    'email',
                    'password'
                ]
            ],
            'group_user' => [
                'dialog' => [
                    'label' => [
                        'group_user_name'
                    ],
                    'placeholder' => [
                        'select_name'
                    ]
                ],
                'table' => [
                    'group_user_name',
                    'email'
                ],
                'breadcrumb' => [
                    'group_user'
                ]
            ],
            'group_permission' => [
                'dialog' => [
                    'label' => [
                        'group_permission_name'
                    ],
                    'placeholder' => [
                        'select_permission'
                    ]
                ],
                'table' => [
                    'group_permission_name'
                ],
                'breadcrumb' => [
                    'group_permission'
                ]
            ],
            'record' => [
                'dialog' => [
                    'placeholder' => [
                        'search'
                    ]
                ],
                'table' => [
                    'operating_object',
                    'action',
                    'modify_content'
                ],
                'breadcrumb' => [
                    'user_record'
                ]
            ]
        ]
    ]
];
