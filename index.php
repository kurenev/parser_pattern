<? session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="/parser_meta_pattern/css/styles.css">
	<script src="/parser_meta_pattern/js/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="/parser_meta_pattern/js/scripts.js"></script>
</head>
<body>
<!-- modals -->
<div class="modal fade add-child">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
				<h4 class="modal-title">Добавить ссылку</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control add_link_parent" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit">Добавить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade add-parent">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
				<h4 class="modal-title">Добавить ссылку</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control add_link_parent" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit">Добавить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade select_type_links">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
				<h4 class="modal-title">Выберите типы страниц, на которых мы будем искать <span class="res_choise_1 text-yellow">разводящие страницы</span></h4>
			</div>
			<div class="modal-body">
				<?/* ... javascript ... */?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary submit">Готово</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<!-- /modals -->
	<div class="container">
		<h3>Проверка мета-тегов по шаблону</h3>
		<div class="our_site col-md-6">
			<h5>Введите сайт <small>(например, http://mysite.ru )</small></h5>
			<input type="text" name="host_name" class="form-control" />
		</div>
		<div class="count_pages col-md-6" style="box-shadow: 0 0 0 1px #FFC55A; background-color: #FFF0D4; color: #CA880E; padding-top: 10px; min-height: 69px;">
			<p>Cтраниц в sitemap.xml: <span>0</span></p>
		</div>
		<div class="clearfix"></div>
		<hr />
		<div class="metas col-md-6">
			<h5>Введите меты "по шаблону" <small>текст текстом, а вставки заключите в фигурные скобки {}</small></h5>
			<table class="table">
				<tr>
					<td>TITLE</td>
					<td><input type="text" name="title" class="form-control" /></td>
				</tr>
				<tr>
					<td>DESCRIPTION</td>
					<td><input type="text" name="description" class="form-control" /></td>
				</tr>
				<tr>
					<td>KEYWORDS</td>
					<td><input type="text" name="keywords" class="form-control" /></td>
				</tr>
			</table>
		</div>
		<div class="inserts col-md-6" style="display: none; padding-top: 1px">
			<h5>Введите селекторы для вставок</h5>
			<table class="table">
			</table>
		</div>
		<div class="clearfix"></div>
		<hr />
		<div class="button_choice col-md-12" style="margin-top: 10px; text-align: center;">
			<p>Будем проверять мета-теги разводящих или карточек?</p>
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-info active">
					<input type="checkbox" autocomplete="off" name="choise" value="list" checked>Разводящие
				</label>
				<label class="btn btn-info">
					<input type="checkbox" autocomplete="off" name="choise" value="item">Карточки
				</label>
			</div>
		</div>
		<div class="clearfix"></div>
		<hr />
		<div class="col-md-6">
			<p style="min-height: 40px">Здесь можете скорректировать страницы, которые будут просканированы и найдены на них <span class="res_choise_1 text-yellow">разводящие страницы</span>.</p>
			<div class="list_links parent">
				<?/* ... javascript ... */?>
			</div>
			<div class="buttons">
				<button class="btn btn-default btn-xs" data-toggle="modal" data-target=".add-parent">Добавить</button>
				<button class="btn btn-success btn-xs activate">Активировать все</button>
				<button class="btn btn-warning btn-xs deactivate">Деактивировать все</button>
				<button class="btn btn-danger btn-xs delete_unactive">Удалить неактивные</button>
				<button class="btn btn-danger btn-xs delete">Удалить все</button>
			</div>
		</div>
		<div class="col-md-6">
			<p style="min-height: 40px">Выберите <span class="res_choise_2 text-yellow">разводящие</span>, на которых будут проверены меты.<br /></p>
			<div class="list_links childs">
				<?/* ... javascript ... */?>
			</div>
			<div class="buttons">
				<button class="btn btn-default btn-xs" data-toggle="modal" data-target=".add-child">Добавить</button>
				<button class="btn btn-success btn-xs activate">Активировать все</button>
				<button class="btn btn-warning btn-xs deactivate">Деактивировать все</button>
				<button class="btn btn-danger btn-xs delete">Удалить все</button>
			</div>
		</div>
		<hr />
		<div class="btn btn-primary next" style="display:none">Дальше &darr;</div>
	</div>
</body>
</html>
