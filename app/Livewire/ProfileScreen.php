<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Filament\Forms\Form;
use WireUi\Traits\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class ProfileScreen extends Component implements  HasForms ,HasActions
{   
    use Actions;
    use InteractsWithActions;
    use InteractsWithForms;
    // use WireUiActions;
    
    public ?array $data = [];

    public $isChangePassword;

    public function mount(){
        $this->isChangePassword = false;   
        $this->form->fill([
            'name'=> Auth::user()->name,
            'email'=> Auth::user()->email,
            'profile_photo_path'=> Auth::user()->profile_photo_path,
          
        ]);
    }

    public function updateAccountAction(): Action
    {
        return Action::make('updateAccount')
        ->label('Update Account')
        ->button()
        ->outlined()
         
            // ...
            ->action(function (array $arguments) {
                $this->updateAccount();
            });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()->label('User Name'),

                    TextInput::make('email')
                    ->unique(ignoreRecord: true)
                    ->label('Profile')
                    ->required()->label('Email'),

                    TextInput::make('password')
                    ->label('New Password')
                    ,

                    FileUpload::make('profile_photo_path')
                    ->disk('public')
                    ->directory('user-profile')
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(2)
                   
                    ->columnSpanFull()
                


            ])
            ->statePath('data');
    }
    
    public function updateAccount()
    {
        // dd($this->form->getState());

        $user  = User::find(Auth::user()->id);
        $name = $this->form->getState()['name'];
        $email = $this->form->getState()['email'];
        $new_password = $this->form->getState()['password'];
        $new_profile = $this->form->getState()['profile_photo_path'];

        if(!empty($new_password)){
            $user->update([
                'name'=> $name,
                'email'=> $email,
                'password'=> Hash::make($new_password),

            ]);
            $user->save();
            
            
        }else{
            $user->update([ 
                'name'=> $name,
                'email'=> $email,

            ]);
            $user->save();

        }

        if(!empty($new_profile)){
            $user->update([

            'profile_photo_path'=> $new_profile,
            ]);

            $user->save();
        }else{
            
            $user->update([

            'profile_photo_path'=> null,
            ]);

            $user->save();
        }
        $this->dialog()->show([
            'icon' => 'success',
            'title' => 'Update Successful!',
            'description' => 'Your account information has been successfully updated.',
        ]);
        
        // return redirect()->back();
        
        // sleep(1);
        return redirect()->route('account.profile');
        

    
       
    }

    public function toggleChangePassword(){

        $this->isChangePassword = !$this->isChangePassword;
    }

    public function render()
    {
        return view('livewire.profile-screen');
    }
}
