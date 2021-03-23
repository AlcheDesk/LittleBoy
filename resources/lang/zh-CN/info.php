<?php
return [

	'dialog' => [
		'title' => [
			//basic
			'add' => '添加:name ',
			'edit' => '编辑:name ',
			'delete' => '删除:name ',
			'view' => '查看:name ',
			'copy' => '复制:name ',
			'delete_info' => '该操作将删除 ',
			'delete_continue' => ' , 是否继续?',
			'delete_tag_continue' => ' 个用例，是否继续？',

			//projectLib
			'notification' => '消息',
			'copy_project_notification' => '项目复制进行中，请等待30s后将自动刷新！',
			'success' => '成功',
			'copy_project_success' => '项目复制成功！',
			'uncopy' => '取消复制',
			'unedit' => '取消编辑',

			//testCase
			'tag_management' => '标签管理',
			'select_or_create_run' => '选择或新建运行计划',
			'add_run_list' => '添加自定义执行列表',
			'select_tag' => '请选择标签(可多选，最多十个)',
			'association' => ' 关联 ',
			'testcase_error_message' => '请选择需要批量添加的测试用例！',
			'delete_warnning' => '删除警告',
			'delete_wrong_message_1' => '不能删除测试用例 ',
			'delete_wrong_message_2' => ' ，该用例已被其它测试用例引用。',

			//instruction
			'insert_bundle' => '插入指令包',
			'instruction_bundle' => '指令包',
			'insert_bundle_set' => '指令包插入设置',
			'reference_testcase' => '引用测试用例',
			'edit_reference_testcase' => '编辑引用测试用例',
			'add_instruction' => '添加测试步骤',
			'add_comment_instruction' => '添加步骤注释',
			'add_rpc_dubbo_instruction' => '添加Rpc(Dubbo)测试步骤',
            'add_check_email_instruction' => '添加校验邮件步骤',
            'edit_check_email_instruction' => '编辑校验邮件步骤',
			'add_processor_instruction' => '添加校验步骤',
			'add_validator_instruction' => '添加校验步骤',
			'add_api_instruction' => '添加API测试步骤',
			'add_webbrowser_action' => '添加浏览器动作',
			'add_stringUtil_instruction' => '添加字符处理步骤',
			'add_sql_statement' => '添加SQL语句',
			'add_js_script' => '添加JS脚本',
			'edit_instruction' => '编辑测试步骤',
			'edit_comment_instruction' => '编辑步骤注释',
			'edit_validator_instruction' => '编辑校验步骤',
			'edit_api_instruction' => '编辑API测试步骤',
			'edit_webbrowser_action' => '编辑浏览器动作',
			'edit_sql_statement' => '编辑SQL语句',
			'edit_js_script' => '编辑JS脚本',
			'edit_rpc_dubbo_instruction' => '编辑DubboService语句',
			'application' => '项目板块',
			'section' => '子版块',
			'element' => '元素',
			'folder' => '收藏夹',
			'target_testcase' => '目标用例',
			'testcase_overwrite' => '用例参数',
			'sql_statement' => 'SQL语句',
			'js_script' => 'JS脚本',
			'webrowser_action' => '浏览器动作',
			'rpc_dubbo' => 'RPC语句名',
			'rpc_dubbo_port' => 'Dubbo端口',
			'rpc_dubbo_zk_host' => 'zk地址',
			'rpc_dubbo_zk_port' => 'zk端口',
			'rpc_dubbo_qos_port' => 'qos端口',
			'rpc_dubbo_interface_name' => 'Dubbo类名',
			'rpc_dubbo_interface_method' => 'Dubbo方法',
			'rpc_dubbo_parameters' => 'Dubbo参数',
            'check_email_subject' => '邮件标题',
            'check_email_subject_check_type' => '标题校验',
            'check_email_content' => '邮件正文',
            'check_email_content_check_type' => '正文校验',
            'check_email_sender' => '发送者姓名',
            'check_email_address' => '发送者邮箱',
            'check_email_time_span' => '时间短于',
			'expression' => '表达式',
			'summary_comment' => '摘要/注释',
			'step' => '步骤',
			'expected' => '预期',
			'drive_dep' => '驱动依赖',
			'drive_need' => '运行该测试用例需要的驱动类型  ',
			'set_cluster' => '设置测试执行集群',
			'execution_cluster' => '执行集群',
			'overwrite_name' => '参数名称',
			'drive_pack' => '驱动包',
			'debug' => '调试',
			'prod' => '运行',
			'run_fail' => '运行失败',
			'fail_message' => '运行失败, 没有数据可供运行',
			'debug_start' => '调试开始',
			'debug_message' => '调试开始，可跳转到运行状态页查看状态！',
			'prod_start' => '运行开始',
			'prod_message' => '运行开始，可跳转到运行状态页查看状态！',
			'operation_error' => '操作错误',
			'error_message' => '该用例已被引用次数超过十次，无法在本用例中建立新的引用！',
			'error_message_run_list' => '该自定义执行列表已被引用，无法在该列表中建立新的引用！',
			'edit_error_message' => "编辑未完成，不能保存！",
			'show_error_message' => "操作有误，选中行多于一行，无法进行下一步操添加作。",
			'data_error_message' => "数据有误，该操作无法进行！",
			'null_error_message' => "操作有误，没有选中数据，无法进行下一步操添加作。",
			'only_error_message' => '操作有误，只能选中一行！',
			'add_error' => '添加发生错误！',
			'select_error_message' => '请先选择项目板块和子版块！',
			'file_type' => '文件类型',
			'file_path' => '文件路径',
			'driver' => '驱动',
			'check_result' => '校验结果',
			'save_result' => '保存结果',
			'stringUtil_action' => '字符处理器动作',

			//folder
			'select_all_error_message' => '操作错误，此处不允许一次选中全部，请依次选择需要添加的测试用例！',

			'insert_location' => '添加测试步骤插入位置',
			'insert_position' => '插入位置',
			'insert_under' => '行下插入',
			'insert_on' => '行上插入',

			'copy_testcase_overwrite' => '复制测试用例参数配置',
			'reference_testcase_overwrite' => '引用用例参数设置',
			'edit_instructin_overwrite_message_1' => '此操作将影响该测试用例下参数配置中的 ',
			'edit_instructin_overwrite_message_2' => ' 个InstructionOverwrite,是否继续？',
			'delete_instruction_overwrite' => '删除测试步骤配置',
			'delete_info_1' => '此操作将删除该测试步骤配置，是否继续？',
			'delete_testcase_overwrite' => '删除测试用例配置',
			'delete_info_2' => '此操作将删除该测试用例配置，是否继续？',

			//move
			'step_move' => '测试步骤移动',
			'direction' => '移动方向',
			'move_up' => '向上移动',
			'move_down' => '向下移动',
			'move_steps' => '移动步数',

			//api
			'select' => '选择',
			'api_name' => '接口名称',
			'api_save_as' => '接口另存为',
			'pre_run' => '预运行',
			'save_not' => '保存JsonPath结果',
			'status_code' => '状态码',
			'debug_result' => '调试结果',
			'api_element_warning_message_1' => '此操作将影响引用该接口元素的 ',
			'api_element_warning_message_2' => ' 个InstructionOverwrite,是否继续？',

			//apiElement
			'save_or_not_change' => '是否保存此次修改?',
			'save_or_not_change_message' => '保存后包含该元素的所有Instruction将会受影响！',
			'unchange' => '取消修改',

			//apiInstruction
			'cancel_change' => '是否放弃此次修改?',
			'cancel_change_message' => '放弃该页面所有操作将被不被保存！',

			//element
			'add_element' => '新建元素',
			'position_attribute' => '定位属性',
			'attribute_value' => '属性值',
			'project' => '项目',
			'un_delete_element' => '无法删除元素 ',
			'not_available' => ' 不可用，有 ',
			'containing_message' => '个测试用例含有该元素。',
			'containing_message_2' => '以下含有该元素的测试用例或引用了含有该元素的测试用例的用例将会受到影响。',
			'edit_element_message_1' => '此操作将影响引用该元素的 ',
			'edit_element_message_2' => ' 个Instruction,是否继续？',

			//runlist
			'project_lib' => '项目库',
			'test_case' => '测试用例',
			'list_name' => '列表名称',
			'refrence_list' => '引用自定义执行列表',
			'set_run_list' => '列表运行通知设置',
			'add_notification' => '添加通知',
			'notification_list' => '通知列表',
			'see_detail' => '查看详情',
			'notification_manage' => '通知管理',
			'set_notification' => '运行通知设置',
			'recipient_manage' => '收件人管理',
			'set_recipient' => '收件人设置',
			'recipient' => '收件人',
			'add_recipient' => '添加收件人',
			'theme' => '主题',
			'email' => '邮箱',
			'once_alarm' => '单次执行',
			'cycling_alarm' => '周期性执行',
			'set_testcase_overwrite' => '用例参数设置',
			'set_testcase_driver' => '用例驱动设置',
			'select_alias' => '选择别名',
			'alias_management' => '别名管理',

			'delete_referen_list_from_list' => '此操作将从列表中移除该自定义执行列表引用 ',
			'delete_testcase_from_list' => '此操作将从列表中移除该测试用例 ',
			'delete_from_list_continue' => ' ，是否继续？',
			'lack_driver_pack' => '驱动包未配置',

			//alarm
			'set_once_success' => '单次闹钟设置成功',
			'set_once_message' => '单次执行闹钟设置成功，到指定时间将会自动执行！',
			'set_cycling_success' => '循环闹钟设置成功',
			'set_ocycling_message' => '循环闹钟设置成功，到指定时间将会自动执行！',
			'please_select_notification' => '请选择要添加的通知后再添加',
			'delete_list_notification' => '删除列表通知',
			'delete_notification_from_list' => '此操作将从该运行列表中删除通知 ',
			'delete_notification' => '删除通知',
			'delete_notification_message' => '此操作将删除通知 ',
			'delete_recipient' => '删除收件人',
			'delete_recipient_message' => '此操作将删除收件人 ',
			'cancel_once_success' => '单次闹钟取消成功',
			'cancel_once_message' => '单次执行闹钟取消成功！ ',
			'cancel_cycling_success' => '循环闹钟取消成功',
			'cancel_ocycling_message' => '循环执行闹钟取消成功！ ',

			//modulePro
			'class_name' => '类名称',
			'user_name' => '用户名',
			'password' => '密码',

			'property_name' => '属性名',
			'defaults' => '默认值',
			'description' => '描述',
			'value_type' => '值类型',
			'value' => '值',
			'delete_driver_message_1' => '删除引擎 ',
			'delete_driver_message_2' => ' 不可用，含有该引擎的引擎包 ',
			'delete_driver_message_3' => ' 将会受到影响。',

			//runResult
			'testcase_stop_success' => '测试用例运行终止成功！',
			'run_log' => '运行日志',
			'log_info' => '日志信息',
			'detail' => '详情',
			'view_screenshot' => '查看截图',
			'project_area_chart' => '项目运行结果面积图',
			'run_result' => '运行结果',
			'project_change' => '项目创建以来成功和错误变化',
			'total_number_testcase' => '测试用例总数',
			'running_total' => '运行总量',
			'project_establishment_time' => '项目建立时间',
			'testcase_run_time' => '测试用例运行时间',
			'found_problem' => '已发现问题',
			'problem_fix' => '问题修复',
			'navigator_testcase' => '前往查看所有测试用例',
			'navigator_testcase_result' => '前往查看测试用例运行结果',
			'run_number' => '运行数目',

			'view_report_details' => '查看列表报告详情',
			'code_info' => '代码信息',
			'expected_value' => '预期值',
			'actual_value' => '实际值',
			'test_instruction' => '测试说明',
			'timeout' => '超时',
			'no_problem' => '没有发现问题',
			'screenshot' => '截图',

			'prompt' => '提示',
			'no_error_testcase' => '该用例下没有错误用例！',
			'rerun_completed' => '重跑操作完成',
			'rerun_start' => '重跑测试用例已启动，请返回查看并等待结果！',
			'view_api' => '查看接口',

		],

		'placeholder' => [
			//basic
			'enter_id' => '请输入编号',
			'enter_name' => '请输入名称',
			'enter_comment' => '请输入备注信息',
			'select_date' => '请选择日期',

			//instructionBundleEntry
			'select_instruction_type' => '请选择步骤类型',
			'select_element_type' => '请选择元素类型',
			'select_action' => '请选择动作',

			//projectLib
			'select_project_type' => '请选择项目类型',

			//testCase
			'select_tag' => '请选择或输入标签，最多四个',
			'select_type' => '请选择类型,默认可不选',
			'select_run_plan' => '请选择运行计划',

			//instruction
			'select' => '请选择(可搜索)',
			'enter' => '请输入',
			'enter_email' => '请输入邮箱，多个邮箱地址请用";"隔开,末尾请勿输入;',

			//runList
			'select_alias' => '选择别名',

		],
	],

	'table' => [
		//basic
		'id' => '编号',
		'name' => '名称',
		'create_at' => '创建时间',
		'update_at' => '更新时间',
		'comment' => '备注',
		'operating' => '操作',
		'start_date' => '开始时间',
		'end_date' => '结束时间',

		//instructionBUndleEntry
		'instruction_type' => '指令类型',
		'element_type' => '元素类型',
		'instruction_action' => '指令动作',

		//projectLib
		'project_type' => '项目类型',

		//testCase
		'tag' => '标签',
		'mark' => '标记',
		'project' => '项目库',

		//insruction
		'target' => '目标',
		'action' => '动作',
		'input' => '内容',
		'option' => '选项',
		'type' => '类型',
		'string_check' => '字符串校验',
		'math_check' => '数学表达式校验',
		'string_util' => '字符串处理',

		//runlist
		'priority' => '优先级',
		'testcase_name' => '测试用例名称',
		'overwrite_name' => '参数名称',
		'driver_name' => '驱动包名称',
		'testcase_comment' => '用例备注',
		'reference_message' => '此处引用了自定义执行列表',
		'testcase_number' => '用例数量',
		'alias' => '别名',

		//modulePro
		'engine_name' => '引擎名称',
		'vendor' => '厂商',
		'version' => '版本',
		'default' => '是否默认',

		//runStatus
		'run_status' => '运行状态',
		'progress' => '进度',
		'has_executed' => '已执行',
		'operating_environment' => '运行环境',

		//runResult
		'testcase_quantity' => '测试用例数量',
		'total_executed' => '已执行总数',
		'run_date' => '运行时间',
		'success_total_last' => '成功/总数(last)',
		'success_total' => '成功/总数',
		'error' => '错误',
		'number_of_run' => '运行次数',
		'not_run' => '未运行',
		'overwrite' => '参数',
		'trigger_source' => '触发源',
		'status' => '状态',
		'driver' => '驱动',
		'pass_rate' => '通过率',

	],

	'operator' => [
		//basic
		'new' => '新建',
		'edit' => '编辑',
		'delete' => '删除',
		'export' => '导出',
		'view' => '查看',
		'copy' => '复制',
		'setting' => '设置',
		'searching' => '搜索',
		'reset' => '重置',
		'undelete' => '取消删除',
		'confirm' => '确定',
		'cancel' => '取消',
		'new_guider' => '新手指引',

		//folder
		'add_to_testcase' => '添加到测试用例',
		'go_to_testcase' => '去用例查看',
		'stay_folder_testcase' => '留在收藏夹',

		//projectLib
		'open' => '打开',
		'test_case' => '测试用例',
		'api_management' => 'API接口管理',
		'soap_management' => 'SOAP接口管理',
		'element_management' => '元素管理',

		//testCase
		'tag' => '标签',
		'select_tag' => '选择标签',
		'tag_management' => '标签管理',
		'add_to_run' => '添加到运行计划',
		'and' => '条件与',
		'or' => '条件或',
		'go_to_run' => '去运行与设置查看',
		'stay_test_case' => '留在用例库',

		//instruction
		'color_label' => '颜色标签',
		'move' => '移动',
		'overwrite' => '新建参数',
		'web_function' => '网页功能',
		'virtual_web_function' => '虚拟网页功能',
		'performance' => '压力',
		'manual' => '手动',
		'reference' => '引用',
		'reference_message' => '此处引用了测试用例',
		'rest_api' => '接口',
		'rpc_dubbo' => 'Dubbo服务',
		'web_browser' => '浏览器',
		'virtual_web_browser' => '虚拟浏览器',
		'sql' => 'SQL',
		'javascript' => 'JS脚本',
		'processor' => '校验',
		'comment' => '备注',
		'run' => '运行',
		'instruction_bundle_insert' => '指令模板插入',
		'view_drive' => '驱动信息查询',
		'edit_done' => '编辑完成',
		'folder_reference' => '收藏夹引用',
		'redis' => '缓存',
		'string_util' => '字符处理',
        'email' => '邮件校验',

		//runlist
		'set_drive' => '设置驱动',
		'set_overwrite' => '设置参数',
		'notification_setting' => '通知设置',
		'add_to_notification_list' => '添加到通知列表',
		'select_alias' => '选择别名',
		'alias_management' => '别名管理',

		//runResult
		'run_result' => '运行结果',
		'debug_result' => '调试结果',
		'project_overview' => '项目概况',
		'summary_result' => '结果总览',
		'error_testcase' => '错误用例',
		'view_report' => '查看报告',
		'terminate_operation' => '终止运行',
		'error_testcase_callback' => '错误用例重跑',
		'view_task' => '查看任务',
	],

	'validator' => [
		'name' => [
			'required' => '不能为空(选择或输入)',
			'exist' => '该名称数据库中已存在，请更改',
			'consists' => '名称由长度为1-32的数字字符下划线汉字组成',
		],
		'project_type' => '项目类型不能为空',
		'url' => '请输入有效完整的URL，例如"http://baidu.com"',
		'email' => '邮箱格式不正确，多个邮箱地址请用";"隔开,末尾请勿输入;',
	],

	'breadcrumb' => [
		//instructionBundle
		'instruction_bundle' => '指令包',
		'bundle_entry' => '模板步骤',

		//folder
		'folder' => '收藏夹',
		'folder_list' => '收藏夹列表',

		//projectLib
		'project_lib' => '项目库',
		'project_list' => '项目列表',
		'test_case' => '测试用例',
		'api_management' => 'API接口管理',
		'soap_management' => 'SOAP接口管理',
		'element_management' => '元素管理',

		//instruction
		'instruction' => '测试步骤',

		//apielement
		'api_element' => '接口元素管理',

		//application
		'application' => '项目板块',
		'section' => '项目子板块',
		'element' => '录入元素',

		//test_case_lib
		'test_case_lib' => '用例库',
		'test_case_list' => '用例列表',

		//runlist
		'run_list' => '运行与设置/自定义执行列表',
		'list_detail' => '列表详情',

		//modulePro
		'engine' => '引擎设置',
		'engine_property' => '引擎属性',
		'engine_package' => '引擎包管理',
		'system_requirements_packs' => '系统需求包',
		'packs_system_requirements' => '系统需求',

		//runStatus
		'project_status' => '项目运行状态',
		'testcase_status' => '测试用例运行状态',
		'run_list_status' => '列表运行状态',
		'list_detail' => '列表详情',

		//runResult
		'project_result' => '项目运行结果',
		'result_detail' => '结果详情',
		'case_result' => '用例结果',
		'step_result' => '步骤结果',
		'list_result' => '列表运行结果',
		'testcase_result' => '用例运行结果',
		'project_global_result' => '项目全局结果',
		'api_detail' => '接口详情',

		'system_set' => '设置',
	],

];
