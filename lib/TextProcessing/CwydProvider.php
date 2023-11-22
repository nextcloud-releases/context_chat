<?php

declare(strict_types=1);
namespace OCA\Cwyd\TextProcessing;

use OCA\Cwyd\Service\LangRopeService;
use OCP\IL10N;
use OCP\TextProcessing\IProvider;
use OCP\TextProcessing\IProviderWithUserId;

/**
 * @template-implements IProviderWithUserId<CwydTaskType>
 * @template-implements IProvider<CwydTaskType>
 */
class CwydProvider implements IProvider, IProviderWithUserId {

	private ?string $userId = null;

	public function __construct(
		private LangRopeService $langRopeService,
		private IL10N $l10n,
	) {
	}

	public function getName(): string {
		return $this->l10n->t('Chat with your documents');
	}

	public function process(string $prompt): string {
		$response = $this->langRopeService->query($this->userId, $prompt);
		if (isset($response['error'])) {
			throw new \RuntimeException('No result in Cwyd response. ' . $response['error']);
		}
		return $response['message'] ?? '';
	}

	public function getTaskType(): string {
		return CwydTaskType::class;
	}

	public function setUserId(?string $userId): void {
		$this->userId = $userId;
	}
}
