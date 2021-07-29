

.PHONY: devmac
devmac: ## Sur MacOS on ne préfèrera exécuter PHP en local pour les performances
	docker-compose -f docker-compose.macos.yml up


