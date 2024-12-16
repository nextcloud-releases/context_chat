<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\ContextChat\TaskProcessing;

use OCA\ContextChat\AppInfo\Application;
use OCP\IL10N;
use OCP\TaskProcessing\EShapeType;
use OCP\TaskProcessing\ITaskType;
use OCP\TaskProcessing\ShapeDescriptor;

class ContextChatTaskType implements ITaskType {
	public const ID = Application::APP_ID . ':context_chat';

	public function __construct(
		private IL10N $l,
	) {
	}

	/**
	 * @inheritDoc
	 * @since 2.3.0
	 */
	public function getName(): string {
		return $this->l->t('Context Chat');
	}

	/**
	 * @inheritDoc
	 * @since 2.3.0
	 */
	public function getDescription(): string {
		return $this->l->t('Ask a question about your data.');
	}

	/**
	 * @return string
	 * @since 2.3.0
	 */
	public function getId(): string {
		return self::ID;
	}

	/**
	 * @return ShapeDescriptor[]
	 * @since 2.3.0
	 */
	public function getInputShape(): array {
		return [
			'prompt' => new ShapeDescriptor(
				$this->l->t('Prompt'),
				$this->l->t('Ask a question about your documents, files and more'),
				EShapeType::Text,
			),
			'scopeType' => new ShapeDescriptor(
				$this->l->t('Scope type'),
				$this->l->t('none, source, provider'),
				EShapeType::Text,
			),
			'scopeList' => new ShapeDescriptor(
				$this->l->t('Scope list'),
				$this->l->t('list of sources or providers'),
				EShapeType::ListOfTexts,
			),
			'scopeListMeta' => new ShapeDescriptor(
				$this->l->t('Scope list metadata'),
				$this->l->t('Required to nicely render the scope list in assistant'),
				EShapeType::Text,
			),
		];
	}

	/**
	 * @return ShapeDescriptor[]
	 * @since 2.3.0
	 */
	public function getOutputShape(): array {
		return [
			'output' => new ShapeDescriptor(
				$this->l->t('Generated response'),
				$this->l->t('The text generated by the model'),
				EShapeType::Text,
			),
			// each string is a json encoded object
			// { id: string, label: string, icon: string, url: string }
			'sources' => new ShapeDescriptor(
				$this->l->t('Sources'),
				$this->l->t('The sources referenced to generate the above response'),
				EShapeType::ListOfTexts,
			),
		];
	}
}
