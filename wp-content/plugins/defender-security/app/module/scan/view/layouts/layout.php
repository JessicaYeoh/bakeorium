<div class="wrap">
    <div id="wp-defender" class="wp-defender">
        <div class="wdf-scanning">
            <h2 class="title">
				<?php _e( "File Scanning", "defender-security" ) ?>
                <span>
                    <form id="start-a-scan" method="post" class="scan-frm">
						<?php
						wp_nonce_field( 'startAScan' );
						?>
                        <input type="hidden" name="action" value="startAScan"/>
                        <button type="submit"
                                class="button button-small"><?php _e( "New Scan", "defender-security" ) ?></button>
                </form>
            </span>
            </h2>

            <div class="scan">
                <div class="dev-box summary-box">
                    <div class="box-content">
                        <div class="columns">
                            <div class="column is-7 issues-count">
                                <div>
                                    <h5 class="def-issues def-issues-top-left"><?php echo $countAll = $model->countAll( \WP_Defender\Module\Scan\Model\Result_Item::STATUS_ISSUE ) ?></h5>
                                    <?php if ( $countAll > 0 ) : ?>
                                    <span class="def-issues-top-left-icon" tooltip="<?php esc_attr_e( sprintf( __('You have %d suspicious file(s) needing attention.', "defender-security" ), $countAll ) ); ?>">
                                    <?php else: ?>
                                    <span class="def-issues-top-left-icon" tooltip="<?php esc_attr_e( 'Your code is clean, the skies are clear.', "defender-security" ); ?>">
                                    <?php endif; ?>
									<?php
									$icon = $countAll == 0 ? ' <i class="def-icon icon-tick" aria-hidden="true"></i>' : ' <i class="def-icon icon-warning fill-red" aria-hidden="true"></i>';
									echo $icon;
									?>
                                </span>
                                    <div class="clear"></div>
                                    <span class="sub"><?php _e( "File scanning issues need attention.", "defender-security" ) ?></span>
                                    <div class="clear mline"></div>
                                    <strong><?php echo $lastScanDate ?></strong>
                                    <span class="sub"><?php _e( "Last scan", "defender-security" ) ?></span>
                                </div>
                            </div>
                            <div class="column is-5">
                                <ul class="dev-list bold">
                                    <li>
                                        <div>
                                            <span class="list-label"><?php _e( "WordPress Core", "defender-security" ) ?></span>
                                            <span class="list-detail def-issues-top-right-wp">
                                                <?php echo $model->getCount( 'core' ) == 0 ? ' <i class="def-icon icon-tick"></i>' : '<span class="def-tag tag-error">' . '<span class="def-issues">' . $model->getCount( 'core' ) . '</span></span>' ?>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="list-label"><?php _e( "Plugins & Themes", "defender-security" ) ?></span>
                                            <span class="list-detail def-issues-top-right-pt">
                                                <?php if ( \WP_Defender\Behavior\Utils::instance()->getAPIKey() ): ?>
	                                                <?php echo $model->getCount( 'vuln' ) == 0 ? ' <i class="def-icon icon-tick"></i>' : '<span class="def-tag tag-error">' . $model->getCount( 'vuln' ) . '</span>' ?>
                                                <?php else: ?>
                                                    <a href="#pro-feature" rel="dialog"
                                                       class="button button-pre button-small" 
                                                       tooltip="<?php esc_attr_e( "Try Defender Pro free today", "defender-security" ) ?>">
                                                        <?php _e( "Pro Feature", "defender-security" ) ?>
                                                    </a>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="list-label"><?php _e( "Suspicious Code", "defender-security" ) ?></span>
                                            <span class="list-detail def-issues-top-right-sc">
                                                <?php if ( \WP_Defender\Behavior\Utils::instance()->getAPIKey() ): ?>
	                                                <?php echo $model->getCount( 'content' ) == 0 ? ' <i class="def-icon icon-tick"></i>' : '<span class="def-tag tag-error">' . $model->getCount( 'content' ) . '</span>' ?>
                                                <?php else: ?>
                                                    <a href="#pro-feature" rel="dialog"
                                                       class="button button-pre button-small"
                                                       tooltip="<?php esc_attr_e( "Try Defender Pro free today", "defender-security" ) ?>" >
                                                        <?php _e( "Pro Feature", "defender-security" ) ?>
                                                    </a>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-third">
						<nav role="navigation" aria-label="Filters">
							<ul class="inner-nav is-hidden-mobile">
								<li class="issues-nav">
									<a class="<?php echo \Hammer\Helper\HTTP_Helper::retrieve_get( 'view', false ) == false ? 'active' : null ?>"
									href="<?php echo network_admin_url( 'admin.php?page=wdf-scan' ) ?>">
										<?php _e( "Issues", "defender-security" ) ?>
										<?php
										$issues = $model->countAll( \WP_Defender\Module\Scan\Model\Result_Item::STATUS_ISSUE );
										$tooltip = '';
										if ( $issues > 0 ) :
											$tooltip = 'tooltip="' . esc_attr( sprintf( __("You have %d suspicious file(s) needing attention", "defender-security" ), $countAll ) ) . '"';
										endif;
										echo $issues > 0 ? '<span class="def-tag tag-error def-issues-below" ' . $tooltip . '>' . $issues . '</span>' : '' ?>
									</a>
								</li>
								<!--                            <li>-->
								<!--                                <a class="-->
								<?php //echo $controller->isView( 'cleaned' ) ? 'active' : null ?><!--"-->
								<!--                                   href="-->
								<?php //echo network_admin_url( 'admin.php?page=wdf-scan&view=cleaned' ) ?><!--">--><?php //_e( "Cleaned", "defender-security" ) ?>
								<!--                                    <span>-->
								<!--                                        --><?php
								//                                        $issues = $model->countAll( \WP_Defender\Module\Scan\Model\Result_Item::STATUS_FIXED );
								//                                        echo $issues > 0 ? $issues : '' ?>
								<!--                                    </span>-->
								<!--                                </a>-->
								<!--                            </li>-->
								<li>
									<a class="<?php echo $controller->isView( 'ignored' ) ? 'active' : null ?>"
									href="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=ignored' ) ?>">
										<?php _e( "Ignored", "defender-security" ) ?>
										<span class="def-ignored">
											<?php
											$issues = $model->countAll( \WP_Defender\Module\Scan\Model\Result_Item::STATUS_IGNORED );
											echo $issues > 0 ? $issues : '' ?>
										</span>
									</a>
								</li>
								<li>
									<a class="<?php echo $controller->isView( 'settings' ) ? 'active' : null ?>"
									href="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=settings' ) ?>">
										<?php _e( "Settings", "defender-security" ) ?></a>
								</li>
								<li>
									<a class="<?php echo $controller->isView( 'reporting' ) ? 'active' : null ?>"
									href="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=reporting' ) ?>">
										<?php _e( "Reporting", "defender-security" ) ?></a>
								</li>
							</ul>
						</nav>
                        <div class="is-hidden-tablet mline">
							<nav role="navigation" aria-label="Filters">
								<select class="mobile-nav">
									<option <?php selected( '', \Hammer\Helper\HTTP_Helper::retrieve_get( 'view' ) ) ?>
											value="<?php echo network_admin_url( 'admin.php?page=wdf-scan' ) ?>"><?php _e( "Issues", "defender-security" ) ?></option>
									<option <?php selected( 'ignored', \Hammer\Helper\HTTP_Helper::retrieve_get( 'view' ) ) ?>
											value="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=ignored' ) ?>"><?php _e( "Ignored", "defender-security" ) ?></option>
									<option <?php selected( 'settings', \Hammer\Helper\HTTP_Helper::retrieve_get( 'view' ) ) ?>
											value="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=settings' ) ?>"><?php _e( "Settings", "defender-security" ) ?></option>
									<option <?php selected( 'reporting', \Hammer\Helper\HTTP_Helper::retrieve_get( 'view' ) ) ?>
											value="<?php echo network_admin_url( 'admin.php?page=wdf-scan&view=reporting' ) ?>"><?php _e( "Reporting", "defender-security" ) ?></option>
								</select>
							</nav>
                        </div>
                    </div>
                    <div class="col-two-third">
						<?php echo $contents ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ( wp_defender()->isFree ) {
	$controller->renderPartial( 'pro-feature' );
} ?>