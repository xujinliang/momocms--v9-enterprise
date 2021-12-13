<!-- Right column/section -->
				<aside class="column width2">
					<div id="rightmenu">
						<header>
							<h3>帐号属性</h3>
						</header>
						<dl class="first">
							<dt><img width="16" height="16" alt="" SRC="img/key.png"></dt>
							<dd><a href="./change_psw.php">管理员 (<?php echo $_SESSION['momocms_admin']; ?>)</a></dd>
							<dd class="last">
								<?php if($_SESSION['momocms_isAdmin']==1){echo '顶级管理账号';}else{echo '演示账号';} ?>
								</dd>
							
							<dt><img width="16" height="16" alt="" SRC="img/help.png"></dt>
							<dd>技术支持</dd>
							<dd class="last">
								<a href="mailto:xujinliang1227@qq.com">xujinliang1227@qq.com</a>
								<div style="clear:both;height:10px;"></div>
							</dd>
						</dl>
					</div>
				</aside>
				<!-- End of Right column/section -->
				
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->
	
	<!-- Page footer -->
	<footer id="bottom">
		<div class="wrapper">
			<p>Copyright &copy; <?php echo date('Y');?>  | Powered BY MoMoCMS</p>
		</div>
	</footer>
	<!-- End of Page footer -->
	
	<!-- Scroll to top link -->
	<a href="#" id="totop">回到顶部</a>

<!-- Admin template javascript load -->
<script type="text/javascript" SRC="js/administry.js"></script>
 </body>
</html>