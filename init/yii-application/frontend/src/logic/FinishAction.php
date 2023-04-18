<?php
namespace src\logic;
	class FinishAction extends Action
	{ 
	public function getName() : string
		{ 
		return ('Завершить');
			}
	protected function getInnerName () : string
	{
		return('act_finish');
	}
	static function getUserProperties (int $user_id, object $obj): bool
	{
	return ($obj->task_host == $user_id);
	}

	public function getButton(): string
    {
        return ('<a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>');
    }

    public function getForm($task_id): string
    {
        return('<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <form>
                <div class="form-group">
                    <label class="control-label" for="completion-comment">Ваш комментарий</label>
                    <textarea id="completion-comment"></textarea>
                </div>
                <p class="completion-head control-label">Оценка работы</p>
                <div class="stars-rating big active-stars"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            </form>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
        ');
    }
	}