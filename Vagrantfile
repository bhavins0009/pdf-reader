Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-16.04"
  config.vm.network "private_network", type: "dhcp"
  config.ssh.forward_agent = true

  config.vm.provider "virtualbox" do |v|
    v.name = "my-test"
    v.customize ["modifyvm", :id, "--memory", "1024"]
    v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
  end

  config.vm.network "forwarded_port", guest: 8000, host: 8001 # nginx app
  config.vm.network "forwarded_port", guest: 8025, host: 8026 # mailhog
end
