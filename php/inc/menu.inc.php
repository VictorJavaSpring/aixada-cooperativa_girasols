<div id="logonStatus">
	<p class="ui-widget">
<?php 
    if (is_created_session()) {
        // Help
        // Aitor: comento líneas 7 y 8 para añadir enlace a Excel de turnos. 12-03-2019.
        // echo '<a href="docs/index_' . get_session_language() . '.php" target="_blank">' .
        //    $Text['nav_help'] . '</a> | ';
        echo '<a href="https://drive.google.com/open?id=1oYjxifuFH5aZ8dJ2-LXUO63eJKeeJ3a-uF3SlDToMlk" target="_blank">Documents</a> | ';	
        echo '<a href="https://drive.google.com/open?id=1NSSk0GmtN3eocx-UKHePr9OiPUa-yY_cgwQLViLhQGA" target="_blank">Excel de Torns 2023</a> | ';	
        echo '<a href="/index.php" target="_blank">Lloc Web</a> | ';	
		
        // Login name and uf_id
        echo  $Text['nav_signedIn'] . " " . get_session_value('login'). 
            " | " . $Text['uf_long'] . ' ' . get_session_value('uf_id') .
            " | " . get_session_value('provider_id');
        
        // Select rol
        echo '<select size="0" name="role_select" id="role_select">';
        foreach (get_session_value('roles') as $role) {
            echo '<option';
            $rt = (isset($Text[$role]) ? $Text[$role] : "TRANSLATE[$role]");
            if ($role == get_current_role()) {
                echo ' selected';
            }
            echo ' value="' . $role. '">' . $rt . '</option>'; 
        } 
        echo '</select> ';

        // Select lang
        $cfg_use_shop = get_config('use_shop', 'order_and_stock');
        if (get_config('show_menu_language_select', false)) {
            echo '<select size="0" name="lang_select" id="lang_select">';
            $keys = get_session_value('language_keys');
            $names = get_session_value('language_names');
            for ($i=0; $i < count($keys); $i++) {
                echo '<option';
                if ($keys[$i] == get_session_value('language')) {
                    echo ' selected';
                }
                echo ' value="' . $keys[$i]. '">' . $names[$i] . '</option>'; 
            } 
            echo '</select> ';
        }
        echo " | ";

        // logout
        echo "<a href='javascript:void(null)' id='logoutRef'>" .
            $Text['nav_logout'] . "</a>";
    } else {
        echo "userdata not set";
        header('Location:login.php');
    }

?>
	</p>
</div>


<div class="ui-widget-header ui-corner-all" id="menuBgBar">
<div  id="topMenu">
<a tabindex="0" href="index.php" 	id="navHome" class="menuTop"><?php echo $Text['nav_home'];?></a>
<a tabindex="1" href="torn.php" 	id="navWizard" class="menuTop"><?php echo $Text['nav_wiz'];?></a>
<?php if ($cfg_use_shop) {  // USE SHOP: start ?>
<a tabindex="2" href="shop_and_order.php?what=Shop" 	id="navShop" class="menuTop"><?php echo $Text['nav_shop'];?></a>
<?php } // - - - - - - - - - - USE SHOP: end ?>
<a tabindex="3" href="shop_and_order.php?what=Order" 		id="navOrder" class="menuTop"><?php echo $Text['nav_order'];?></a>
<a tabindex="4" href="#" 			id="navManage" class="menuTop"><?php echo $Text['nav_mng'];?></a>
<a tabindex="5" href="#" id="navReport" class="menuTop"><?php echo $Text['nav_report'];?></a>
<a tabindex="6" href="#" id="navIncidents" class="menuTop"><?php echo $Text['nav_incidents'];?></a>
<a tabindex="7" href="#" id="navMyAccount" class="menuTop"><?php echo $Text['nav_myaccount'];?></a>
</div>
</div>


<div id="navManageItems" class="hidden">
	<ul>
		<li><a href="manage_ufmember.php"><?php echo $Text['uf_short'];?> & <?php echo $Text['nav_mng_member'];?></a>
			<ul>
			<li>
            <?php 
            	if (get_current_role() == 'Hacker Commission') {
     				echo '<a href="activate_all_roles.php">';
 				} else {
     				echo '<a href="activate_roles.php">';
 				}  
 				echo $Text['nav_mng_roles'];?>
 		</a></li>
			</ul>
		</li>
		
		<li><a href="manage_providers.php"><?php echo $Text['nav_mng_providers'];?></a></li>
		<li><a href="manage_providers.php"><?php echo $Text['nav_mng_products'];?></a>
			<ul>
				<li><a href="manage_orderable_products.php"><?php echo $Text['nav_mng_deactivate'];?></a></li>
				<li><a href="manage_data.php?table=aixada_unit_measure"><?php echo $Text['nav_mng_units'];?></a></li>
				<!-- li><a href="manage_stock.php"><?php echo $Text['nav_mng_stock'];?> </a></li-->
				<li><a href="manage_data.php?table=aixada_iva_type"><?php echo $Text['nav_mng_iva']; ?></a></li>
				<li><a href="manage_data.php?table=aixada_rev_tax_type"><?php echo $Text['nav_mng_revtax']; ?></a></li>
			</ul>
		</li>
		<li><a href="manage_orders.php"><?php echo $Text['nav_mng_orders'];?></a></li>
			<!--  ul>

				<li><a href="manage_preorders.php"><?php echo $Text['nav_mng_preorder'];?></a></li>
			</ul>
		</li-->
		<li><a href="manage_money.php"><?php echo $Text['nav_mng_money'];?></a>
			<ul>
				<li><a href="manage_data.php?table=aixada_account_desc"><?php echo $Text['nav_mng_accdec']; ?></a></li>
				<li><a href="manage_data.php?table=aixada_payment_method"><?php echo $Text['nav_mng_paymeth']; ?></a></li>
			</ul></li>
		<li><a href="#TODO"><?php echo $Text['nav_mng_admin'];?></a>
			<ul>
				<li><a href="manage_admin.php"><?php echo $Text['nav_mng_db'];?></a></li>
				<!-- li><a href="#TODO"><?php echo $Text['nav_mng_users'];?></a></li>
				<li><a href="#TODO"><?php echo $Text['nav_mng_access_rights'];?></a></li-->
				<li><a href="#TODO"><?php echo $Text['nav_mng_aux'] ?></a>
					<ul>
						<li><a href="manage_data.php?table=aixada_stock_movement_type"><?php echo $Text['nav_mng_movtype']; ?></a></li>
					</ul></li>
			</ul>
		</li>

		
	</ul>
</div>

<div id="navReportItems" class="hidden">
	<ul>
		<li><a href="#"><?php echo $Text['nav_report_sales']; ?></a>
			<ul>
				<li><a href="report_shop_ufs.php"><?php echo $Text['nav_report_shop_hu']; ?></a></li>
				<li><a href="report_sales.php"><?php echo $Text['nav_report_shop_pv']; ?></a></li>
			</ul>
		</li>
		<li><a href="report_account.php"><?php echo $Text['nav_report_account'];?></a></li>
		<li><a href="report_stock.php"><?php echo $Text['nav_mng_stock'];?></a></li>
		
		<li><a href="report_torn.php"><?php echo $Text['nav_report_daystats'];?></a></li>
		<li><a href="#"><?php echo $Text['nav_report_timelines'];?></a>
                <ul>
                 <li><a href="report_timelines.php?oper=uf"><?php echo $Text['nav_report_timelines_uf'];?></a></li>
                 <li><a href="report_timelines.php?oper=provider"><?php echo $Text['nav_report_timelines_provider'];?></a></li>
                 <li><a href="report_timelines.php?oper=product"><?php echo $Text['nav_report_timelines_product'];?></a></li>
                </ul>
                </li>
		<!-- li><a href="report_incidents.php"><?php echo $Text['nav_report_incidents'];?></a></li-->
	</ul>
</div>

<div id="navIncidentsItems" class="hidden">
	<ul>
		<li><a href="incidents.php"><?php echo $Text['nav_browse'];?></a></li>
	</ul>
</div>

<div id="navMyAcountItems" class="hidden">
	<ul>
		<li><a href="manage_mysettings.php"><?php echo $Text['nav_myaccount_settings'];?></a></li>
		<li><a href="manage_mysettings.php?what=pwd"><?php echo $Text['nav_changepwd'];?></a></li>
		<li><a href="report_account.php?what=my_account"><?php echo $Text['nav_myaccount_account'];?></a></li>		
		<!-- li><a href="my_prevorders.php"><?php echo $Text['nav_prev_orders'];?></a></li-->
	</ul>
</div>
