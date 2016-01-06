{use class="yii\helpers\Html"}
{use class="yii\grid\GridView"}
{use class="app\helper\UrlHelper"}

<div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">{Html::a('`page.create_page`', 'admin/page/create', ['class' => 'btn btn-flat btn-primary'])}</h3>

			<div class="box-tools">
				<div class="input-group input-group-sm" style="width:150px;">
					<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

					<div class="input-group-btn">
						<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
				<tbody><tr>
					<th>#</th>
					<th>`page.title`</th>
					<td>`page.created_at`</td>
					<th>`page.options`</th>
				</tr>
				{foreach $dataProvider->getModels() as $i => $page}
					<tr>
						<td>{$i+1}</td>
						<td>
							<a href="{UrlHelper::niceUrlTo($page)}">
								{$page->title}
							</a>
						</td>
						<td>
							{$page->created_at}
						</td>
						<td>
							<a href="/admin/page/edit?id={$page->id}" class="glyphicon glyphicon-edit" aria-hidden="true" title="`page.edit`"></a>
							<a href="/admin/page/delete?id={$page->id}" class="glyphicon glyphicon-trash" aria-hidden="true" title="`page.delete_page`"></a>
						</td>
					</tr>
				{/foreach}
				</tbody></table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>
